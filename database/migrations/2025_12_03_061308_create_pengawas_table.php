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
        Schema::create('pengawas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('koperasi_id');
            $table->string('nama');
            $table->enum('posisi', ['Ketua', 'Anggota']);
            $table->timestamps();

            $table->foreign('koperasi_id')->references('id')->on('koperasi')->cascadeOnDelete();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawas');
    }
};
