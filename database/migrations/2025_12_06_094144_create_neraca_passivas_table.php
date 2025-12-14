<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('neraca_passiva', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('performa_bisnis_id')->nullable();
            $table->integer('hutang_lancar')->nullable();
            $table->integer('hutang_jangka_panjang')->nullable();
            $table->integer('total_hutang')->nullable();
            $table->integer('modal')->nullable();
            $table->integer('total_passiva')->nullable();
            $table->timestamps();

            $table->foreign('performa_bisnis_id')->references('id')->on('performa_bisnis')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('neraca_passiva');
    }
};
