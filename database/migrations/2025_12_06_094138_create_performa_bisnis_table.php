<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('performa_bisnis', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('performa_id')->nullable();
            $table->boolean('proyeksi_rugi_laba')->default(false);
            $table->boolean('proyeksi_arus_kas')->default(false);
            $table->unsignedBigInteger('responden_id')->nullable();
            $table->timestamps();

            $table->foreign('performa_id')->references('id')->on('performa')->cascadeOnDelete();
            $table->foreign('responden_id')->references('id')->on('responden')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performa_bisnis');
    }
};
