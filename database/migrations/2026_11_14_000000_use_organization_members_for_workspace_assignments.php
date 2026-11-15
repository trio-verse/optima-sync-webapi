<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $dbName = DB::getDatabaseName();

        // 1. إضافة الأعمدة الجديدة إذا لم تكن موجودة
        if (!Schema::hasColumn('workspace_members', 'organization_member_id')) {
            Schema::table('workspace_members', function (Blueprint $table): void {
                $table->unsignedBigInteger('organization_member_id')->nullable()->after('workspace_id');
            });
        }

        if (!Schema::hasColumn('tasks', 'organization_member_id')) {
            Schema::table('tasks', function (Blueprint $table): void {
                $table->unsignedBigInteger('organization_member_id')->nullable()->after('workspace_id');
            });
        }

        // 2. نقل البيانات فقط في حال وجود العمود القديم member_id
        if (Schema::hasColumn('workspace_members', 'member_id')) {
            foreach (DB::table('workspace_members')->whereNull('organization_member_id')->get() as $workspaceMember) {
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

        if (Schema::hasColumn('tasks', 'member_id') && Schema::hasColumn('workspace_members', 'member_id')) {
            foreach (DB::table('tasks')->whereNotNull('member_id')->whereNull('organization_member_id')->get() as $task) {
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

        // 3. تنظيف الأعمدة القديمة من workspace_members
        if (Schema::hasColumn('workspace_members', 'member_id')) {
            $oldFk = $this->getForeignKeyName($dbName, 'workspace_members', ['member_id']);
            Schema::table('workspace_members', function (Blueprint $table) use ($oldFk): void {
                if ($oldFk) {
                    $table->dropForeign($oldFk);
                }
                $table->dropColumn('member_id');
            });
        }

        // 4. إضافة قيود workspace_members الجديدة إذا لم تكن موجودة فعلياً
        if (!$this->getForeignKeyName($dbName, 'workspace_members', ['organization_member_id'])) {
            Schema::table('workspace_members', function (Blueprint $table): void {
                $table->foreign('organization_member_id')
                    ->references('id')
                    ->on('organization_members')
                    ->cascadeOnDelete();
            });
        }

        if (!$this->hasUniqueIndex($dbName, 'workspace_members', ['workspace_id', 'organization_member_id'])) {
            Schema::table('workspace_members', function (Blueprint $table): void {
                $table->unique(['workspace_id', 'organization_member_id']);
            });
        }

        // 5. تنظيف الأعمدة القديمة من tasks
        if (Schema::hasColumn('tasks', 'member_id')) {
            $oldTaskFk = $this->getForeignKeyName($dbName, 'tasks', ['member_id']);
            Schema::table('tasks', function (Blueprint $table) use ($oldTaskFk): void {
                if ($oldTaskFk) {
                    $table->dropForeign($oldTaskFk);
                }
                $table->dropColumn('member_id');
            });
        }

        // 6. إضافة قيود وفهارس tasks الجديدة إذا لم تكن موجودة فعلياً
        if (!$this->getForeignKeyName($dbName, 'tasks', ['organization_member_id'])) {
            Schema::table('tasks', function (Blueprint $table): void {
                $table->foreign('organization_member_id')
                    ->references('id')
                    ->on('organization_members')
                    ->nullOnDelete();
            });
        }

        if (!$this->getForeignKeyName($dbName, 'tasks', ['workspace_id', 'organization_member_id'])) {
            Schema::table('tasks', function (Blueprint $table): void {
                $table->foreign(['workspace_id', 'organization_member_id'])
                    ->references(['workspace_id', 'organization_member_id'])
                    ->on('workspace_members')
                    ->restrictOnDelete();
            });
        }

        if (!$this->hasIndex($dbName, 'tasks', ['workspace_id', 'organization_member_id'])) {
            Schema::table('tasks', function (Blueprint $table): void {
                $table->index(['workspace_id', 'organization_member_id']);
            });
        }
    }

    public function down(): void
    {
        $dbName = DB::getDatabaseName();

        $compositeFk = $this->getForeignKeyName($dbName, 'tasks', ['workspace_id', 'organization_member_id']);
        if ($compositeFk) {
            Schema::table('tasks', fn (Blueprint $table) => $table->dropForeign($compositeFk));
        }

        $taskOrgFk = $this->getForeignKeyName($dbName, 'tasks', ['organization_member_id']);
        if ($taskOrgFk) {
            Schema::table('tasks', fn (Blueprint $table) => $table->dropForeign($taskOrgFk));
        }

        if ($this->hasIndex($dbName, 'tasks', ['workspace_id', 'organization_member_id'])) {
            Schema::table('tasks', fn (Blueprint $table) => $table->dropIndex(['workspace_id', 'organization_member_id']));
        }

        if (!Schema::hasColumn('tasks', 'member_id')) {
            Schema::table('tasks', fn (Blueprint $table) => $table->unsignedBigInteger('member_id')->nullable()->after('workspace_id'));
        }

        if ($this->hasUniqueIndex($dbName, 'workspace_members', ['workspace_id', 'organization_member_id'])) {
            Schema::table('workspace_members', fn (Blueprint $table) => $table->dropUnique(['workspace_id', 'organization_member_id']));
        }

        $wmOrgFk = $this->getForeignKeyName($dbName, 'workspace_members', ['organization_member_id']);
        if ($wmOrgFk) {
            Schema::table('workspace_members', fn (Blueprint $table) => $table->dropForeign($wmOrgFk));
        }

        if (!Schema::hasColumn('workspace_members', 'member_id')) {
            Schema::table('workspace_members', fn (Blueprint $table) => $table->unsignedBigInteger('member_id')->nullable()->after('workspace_id'));
        }

        if (Schema::hasColumn('workspace_members', 'organization_member_id')) {
            DB::table('workspace_members')->update([
                'member_id' => DB::raw('(select user_id from organization_members where organization_members.id = workspace_members.organization_member_id)'),
            ]);
            Schema::table('workspace_members', function (Blueprint $table): void {
                $table->dropColumn('organization_member_id');
                $table->foreign('member_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }

        if (Schema::hasColumn('tasks', 'organization_member_id')) {
            DB::table('tasks')->update([
                'member_id' => DB::raw('(select user_id from organization_members where organization_members.id = tasks.organization_member_id)'),
            ]);
            Schema::table('tasks', function (Blueprint $table): void {
                $table->dropColumn('organization_member_id');
                $table->foreign('member_id')->references('id')->on('users')->nullOnDelete();
            });
        }
    }

    /**
     * التحقق من وجود Foreign Key بناءً على الأعمدة المرتبطة به بالضبط
     */
    private function getForeignKeyName(string $dbName, string $table, array $columns): ?string
    {
        $constraints = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', $dbName)
            ->where('TABLE_NAME', $table)
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->select('CONSTRAINT_NAME', 'COLUMN_NAME')
            ->orderBy('ORDINAL_POSITION')
            ->get()
            ->groupBy('CONSTRAINT_NAME');

        foreach ($constraints as $name => $rows) {
            if ($rows->pluck('COLUMN_NAME')->values()->all() === $columns) {
                return $name;
            }
        }

        return null;
    }

    private function hasUniqueIndex(string $dbName, string $table, array $columns): bool
    {
        $indexes = DB::table('information_schema.STATISTICS')
            ->where('TABLE_SCHEMA', $dbName)
            ->where('TABLE_NAME', $table)
            ->where('NON_UNIQUE', 0)
            ->select('INDEX_NAME', 'COLUMN_NAME')
            ->orderBy('SEQ_IN_INDEX')
            ->get()
            ->groupBy('INDEX_NAME');

        foreach ($indexes as $rows) {
            if ($rows->pluck('COLUMN_NAME')->values()->all() === $columns) {
                return true;
            }
        }

        return false;
    }

    private function hasIndex(string $dbName, string $table, array $columns): bool
    {
        $indexes = DB::table('information_schema.STATISTICS')
            ->where('TABLE_SCHEMA', $dbName)
            ->where('TABLE_NAME', $table)
            ->select('INDEX_NAME', 'COLUMN_NAME')
            ->orderBy('SEQ_IN_INDEX')
            ->get()
            ->groupBy('INDEX_NAME');

        foreach ($indexes as $rows) {
            if ($rows->pluck('COLUMN_NAME')->values()->all() === $columns) {
                return true;
            }
        }

        return false;
    }
};