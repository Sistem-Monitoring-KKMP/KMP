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
            Schema::create('koperasi', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('kontak');
                $table->string('no_badan_hukum')->nullable();
                $table->integer('tahun')->nullable();
                $table->enum('status', ['Aktif', 'TidakAktif', 'Pembentukan']);
                $table->timestamps();
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koperasis');
    }
};
