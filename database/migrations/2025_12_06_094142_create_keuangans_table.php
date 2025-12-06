<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('performa_bisnis_id')->nullable();
            $table->integer('pinjaman_bank')->nullable();
            $table->integer('investasi')->nullable();
            $table->integer('modal_kerja')->nullable();
            $table->integer('simpanan_anggota')->nullable();
            $table->integer('hibah')->nullable();
            $table->integer('omset')->nullable();
            $table->integer('operasional')->nullable();
            $table->integer('surplus')->nullable();
            $table->timestamps();

            $table->foreign('performa_bisnis_id')->references('id')->on('performa_bisnis')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
