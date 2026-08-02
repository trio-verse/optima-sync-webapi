<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('restrict');
            $table->string('name');
            $table->enum('client_type', [
                'company',
                'individual',
                'government',
                'charity',
                'agency'
            ]);
            $table->foreignId('city_id')->constrained('cities')->onDelete('restrict');
            $table->foreignId('industry_id')->constrained('industries')->onDelete('restrict');
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
