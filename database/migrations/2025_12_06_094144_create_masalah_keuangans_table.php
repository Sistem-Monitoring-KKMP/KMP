<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('masalah_keuangan', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('performa_bisnis_id')->nullable();
            $table->boolean('rugi_keseluruhan')->default(false);
            $table->boolean('rugi_sebagian')->default(false);
            $table->boolean('arus_kas')->default(false);
            $table->boolean('piutang')->default(false);
            $table->boolean('jatuh_tempo')->default(false);
            $table->boolean('kredit')->default(false);
            $table->boolean('penggelapan')->default(false);
            $table->timestamps();

            $table->foreign('performa_bisnis_id')->references('id')->on('performa_bisnis')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masalah_keuangan');
    }
};
