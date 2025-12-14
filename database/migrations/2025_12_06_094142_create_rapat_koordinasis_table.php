<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rapat_koordinasi', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('performa_organisasi_id')->nullable();
            $table->enum('rapat_pengurus', ['satu_minggu','dua_minggu','satu_bulan','dua_bulan','tiga_bulan_lebih'])->nullable();
            $table->enum('rapat_pengawas', ['satu_minggu','dua_minggu','satu_bulan','dua_bulan','tiga_bulan_lebih'])->nullable();
            $table->enum('rapat_gabungan', ['satu_minggu','dua_minggu','satu_bulan','dua_bulan','tiga_bulan_lebih'])->nullable();
            $table->enum('rapat_pengurus_karyawan', ['satu_minggu','dua_minggu','satu_bulan','dua_bulan','tiga_bulan_lebih'])->nullable();
            $table->enum('rapat_pengurus_anggota', ['satu_minggu','dua_minggu','satu_bulan','dua_bulan','tiga_bulan_lebih'])->nullable();
            $table->timestamps();

            $table->foreign('performa_organisasi_id')->references('id')->on('performa_organisasi')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapat_koordinasi');
    }
};
