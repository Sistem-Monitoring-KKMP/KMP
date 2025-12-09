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
            $table->double('cdi')->nullable();
            $table->double('bdi')->nullable();
            $table->double('odi')->nullable();
            $table->enum('kuadrant', ['1', '2', '3', '4'])->nullable();
            $table->date('periode');
            $table->timestamps();

            $table->foreign('koperasi_id')->references('id')->on('koperasi')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performa');
    }
};
