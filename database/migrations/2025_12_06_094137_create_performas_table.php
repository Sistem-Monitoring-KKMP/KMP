<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('performa', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('koperasi_id');
            $table->integer('cdi')->nullable();
            $table->integer('bdi')->nullable();
            $table->integer('odi')->nullable();
            $table->integer('kuadrant')->nullable();
            $table->date('periode')->nullable();
            $table->timestamps();

            $table->foreign('koperasi_id')->references('id')->on('koperasi')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performa');
    }
};
