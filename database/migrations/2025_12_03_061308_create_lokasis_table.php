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
        Schema::create('lokasi', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('koperasi_id');
        $table->unsignedBigInteger('kelurahan_id');
        $table->unsignedBigInteger('kecamatan_id');
        $table->string('alamat');
        $table->decimal('longitude', 10, 6);
        $table->decimal('latitude', 10, 6);
        $table->timestamps();

        $table->foreign('koperasi_id')->references('id')->on('koperasi')->cascadeOnDelete();
        $table->foreign('kelurahan_id')->references('id')->on('kelurahan');
        $table->foreign('kecamatan_id')->references('id')->on('kecamatan');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasis');
    }
};
