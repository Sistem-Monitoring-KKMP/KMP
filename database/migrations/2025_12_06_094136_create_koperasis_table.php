<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('koperasi', function (Blueprint $table) {
            $table->id('id');
            $table->string('nama');
            $table->string('kontak')->nullable();
            $table->string('no_badan_hukum')->nullable();
            $table->integer('tahun')->nullable()->default(2025);
            $table->unsignedBigInteger('responden_id')->nullable(); // ref: - Responden.id (nullable)
            $table->timestamps();

            $table->foreign('responden_id')->references('id')->on('responden')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koperasi');
    }
};
