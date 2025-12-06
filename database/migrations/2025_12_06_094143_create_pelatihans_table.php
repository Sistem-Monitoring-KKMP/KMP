<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelatihan', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('performa_organisasi_id');
            $table->enum('pelatihan', ['Pengurus','Pengawas','GeneralManager','Karyawan','Anggota','NonAnggota'])->nullable();
            $table->integer('akumulasi')->nullable();
            $table->timestamps();

            $table->foreign('performa_organisasi_id')->references('id')->on('performa_organisasi')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelatihan');
    }
};
