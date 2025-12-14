<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lokasi', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('koperasi_id')->nullable();
            $table->unsignedBigInteger('kelurahan_id')->nullable();
            $table->unsignedBigInteger('kecamatan_id')->nullable();
            $table->string('alamat');
            $table->decimal('longitude', 10, 6)->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->timestamps();

            $table->foreign('koperasi_id')->references('id')->on('koperasi')->cascadeOnDelete();
            $table->foreign('kelurahan_id')->references('id')->on('kelurahan')->nullOnDelete();
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi');
    }
};
