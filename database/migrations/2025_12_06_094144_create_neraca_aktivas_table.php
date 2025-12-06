<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('neraca_aktiva', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('performa_bisnis_id')->nullable();
            $table->integer('kas')->nullable();
            $table->integer('piutang')->nullable();
            $table->integer('aktiva_lancar')->nullable();
            $table->integer('tanah')->nullable();
            $table->integer('bangunan')->nullable();
            $table->integer('kendaraan')->nullable();
            $table->integer('aktiva_tetap')->nullable();
            $table->integer('total_aktiva')->nullable();
            $table->timestamps();

            $table->foreign('performa_bisnis_id')->references('id')->on('performa_bisnis')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('neraca_aktiva');
    }
};
