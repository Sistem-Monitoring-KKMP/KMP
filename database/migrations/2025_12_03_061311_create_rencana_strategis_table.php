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
        Schema::create('rencana_strategis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('performa_organisasi_id');
            $table->boolean('visi');
            $table->boolean('misi');
            $table->boolean('rencana_strategis');
            $table->boolean('sasaran_operasional');
            $table->boolean('art');
            $table->timestamps();

            $table->foreign('performa_organisasi_id')->references('id')->on('performa_organisasi')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_strategis');
    }
};
