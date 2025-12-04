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
        Schema::create('performa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('koperasi_id');
            $table->integer('cdi');
            $table->integer('bdi');
            $table->integer('odi');
            $table->integer('kuadrant');
            $table->date('periode');
            $table->timestamps();

            $table->foreign('koperasi_id')->references('id')->on('koperasi')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performas');
    }
};
