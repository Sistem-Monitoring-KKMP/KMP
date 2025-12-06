<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('performa_organisasi', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('performa_id');
            $table->unsignedBigInteger('responden_id')->nullable();
            $table->integer('jumlah_pengurus')->nullable();
            $table->integer('jumlah_pengawas')->nullable();
            $table->integer('jumlah_karyawan')->nullable();
            $table->enum('status', ['Aktif','TidakAktif','Pembentukan'])->nullable();
            $table->integer('total_anggota')->nullable();
            $table->integer('anggota_aktif')->nullable();
            $table->integer('anggota_tidak_aktif')->nullable();
            $table->boolean('general_manager')->default(false);
            $table->boolean('rapat_tepat_waktu')->default(false);
            $table->boolean('rapat_luar_biasa')->default(false);
            $table->boolean('pergantian_pengurus')->default(false);
            $table->boolean('pergantian_pengawas')->default(false);
            $table->timestamps();

            $table->foreign('performa_id')->references('id')->on('performa')->cascadeOnDelete();
            $table->foreign('responden_id')->references('id')->on('responden')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performa_organisasi');
    }
};
