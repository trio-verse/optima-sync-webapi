<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function (): void {
            // 1. إضافة الأعمدة الجديدة إذا لم تكن موجودة
            Schema::table('workspace_members', function (Blueprint $table): void {
                if (!Schema::hasColumn('workspace_members', 'organization_member_id')) {
                    $table->unsignedBigInteger('organization_member_id')->nullable()->after('workspace_id');
                }
            });

            Schema::table('tasks', function (Blueprint $table): void {
                if (!Schema::hasColumn('tasks', 'organization_member_id')) {
                    $table->unsignedBigInteger('organization_member_id')->nullable()->after('workspace_id');
                }
            });

            // 2. نقل البيانات فقط إذا كان عمود member_id ما زال موجوداً ولم يتم حذفه في تشغيلة سابقة
            if (Schema::hasColumn('workspace_members', 'member_id')) {
                foreach (DB::table('workspace_members')->get() as $workspaceMember) {
                    $organizationId = DB::table('workspaces')
                        ->where('id', $workspaceMember->workspace_id)
                        ->value('organization_id');

                    $organizationMemberId = DB::table('organization_members')
                        ->where('organization_id', $organizationId)
                        ->where('user_id', $workspaceMember->member_id)
                        ->value('id');

                    if ($organizationMemberId === null) {
                        $isOwner = DB::table('organizations')
                            ->where('id', $organizationId)
                            ->where('user_id', $workspaceMember->member_id)
                            ->exists();

                        if ($isOwner) {
                            $organizationMemberId = DB::table('organization_members')->insertGetId([
                                'organization_id' => $organizationId,
                                'user_id' => $workspaceMember->member_id,
                                'role' => 'admin',
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }

                    if ($organizationMemberId === null) {
                        throw new RuntimeException(
                            "Workspace member {$workspaceMember->id} cannot be mapped to an organization member."
                        );
                    }

                    DB::table('workspace_members')
                        ->where('id', $workspaceMember->id)
                        ->update(['organization_member_id' => $organizationMemberId]);
                }
            }

            if (Schema::hasColumn('tasks', 'member_id')) {
                foreach (DB::table('tasks')->whereNotNull('member_id')->get() as $task) {
                    $organizationMemberId = DB::table('workspace_members')
                        ->where('workspace_id', $task->workspace_id)
                        ->where('member_id', $task->member_id)
                        ->value('organization_member_id');

                    if ($organizationMemberId === null) {
                        throw new RuntimeException(
                            "Task {$task->id} cannot be mapped to a workspace organization member."
                        );
                    }

                    DB::table('tasks')
                        ->where('id', $task->id)
                        ->update(['organization_member_id' => $organizationMemberId]);
                }
            }

            // 3. حذف الأعمدة القديمة والقيود فقط إذا كانت موجودة
            Schema::table('workspace_members', function (Blueprint $table): void {
                if (Schema::hasColumn('workspace_members', 'member_id')) {
                    try {
                        $table->dropForeign(['member_id']);
                    } catch (\Throwable $e) {
                        // تجاهل الخطأ إذا كان المفتاح غير موجود
                    }
                    $table->dropColumn('member_id');
                }

                if (!collect(Schema::getIndexes('workspace_members'))->contains('name', 'workspace_members_workspace_id_organization_member_id_unique')) {
                    $table->foreign('organization_member_id')
                        ->references('id')
                        ->on('organization_members')
                        ->cascadeOnDelete();
                    
                    $table->unique(['workspace_id', 'organization_member_id']);
                }
            });

            Schema::table('tasks', function (Blueprint $table): void {
                if (Schema::hasColumn('tasks', 'member_id')) {
                    try {
                        $table->dropForeign(['member_id']);
                    } catch (\Throwable $e) {
                        // تجاهل الخطأ إذا كان المفتاح غير موجود
                    }
                    $table->dropColumn('member_id');
                }

                // إضافة القيود الجديدة إذا لم تكن موجودة مسبقاً
                $table->foreign('organization_member_id')
                    ->references('id')
                    ->on('organization_members')
                    ->nullOnDelete();
                
                $table->foreign(['workspace_id', 'organization_member_id'])
                    ->references(['workspace_id', 'organization_member_id'])
                    ->on('workspace_members')
                    ->restrictOnDelete();
                
                $table->index(['workspace_id', 'organization_member_id']);
            });
        });
    }

    public function down(): void
    {
        DB::transaction(function (): void {
            Schema::table('tasks', function (Blueprint $table): void {
                $table->dropForeign(['workspace_id', 'organization_member_id']);
                $table->dropForeign(['organization_member_id']);
                $table->dropIndex(['workspace_id', 'organization_member_id']);
                if (!Schema::hasColumn('tasks', 'member_id')) {
                    $table->unsignedBigInteger('member_id')->nullable()->after('workspace_id');
                }
            });

            Schema::table('workspace_members', function (Blueprint $table): void {
                $table->dropUnique(['workspace_id', 'organization_member_id']);
                $table->dropForeign(['organization_member_id']);
                if (!Schema::hasColumn('workspace_members', 'member_id')) {
                    $table->unsignedBigInteger('member_id')->nullable()->after('workspace_id');
                }
            });

            DB::table('workspace_members')->update([
                'member_id' => DB::raw('(select user_id from organization_members where organization_members.id = workspace_members.organization_member_id)'),
            ]);

            DB::table('tasks')->update([
                'member_id' => DB::raw('(select user_id from organization_members where organization_members.id = tasks.organization_member_id)'),
            ]);

            Schema::table('workspace_members', function (Blueprint $table): void {
                $table->dropColumn('organization_member_id');
                $table->foreign('member_id')->references('id')->on('users')->cascadeOnDelete();
            });

            Schema::table('tasks', function (Blueprint $table): void {
                $table->dropColumn('organization_member_id');
                $table->foreign('member_id')->references('id')->on('users')->nullOnDelete();
            });
        });
    }
};