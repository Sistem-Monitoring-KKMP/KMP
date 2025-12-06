<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('unit_usaha', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('performa_bisnis_id');
            $table->enum('unit', [
                'Gerai Sembako','Klinik Desa','Gerai Obat','Jasa Logistik','Gudang','Simpan Pinjam','Unit Lain'
            ])->nullable();
            $table->integer('volume_usaha')->nullable();
            $table->integer('investasi')->nullable();
            $table->integer('model_kerja')->nullable();
            $table->integer('surplus')->nullable();
            $table->integer('jumlah_sdm')->nullable();
            $table->integer('jumlah_anggota')->nullable();
            $table->timestamps();

            $table->foreign('performa_bisnis_id')->references('id')->on('performa_bisnis')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_usaha');
    }
};
