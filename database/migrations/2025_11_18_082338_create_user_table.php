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
        Schema::create('user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'anggota', 'superadmin'])->default('anggota');
            $table->uuid('anggota_id')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('anggota_id')
                ->references('id')
                ->on('anggota')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('anggota_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
