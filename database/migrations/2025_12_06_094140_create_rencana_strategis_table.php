<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rencana_strategis', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('performa_organisasi_id');
            $table->boolean('visi')->default(false);
            $table->boolean('misi')->default(false);
            $table->boolean('rencana_strategis')->default(false);
            $table->boolean('sasaran_operasional')->default(false);
            $table->boolean('art')->default(false);
            $table->timestamps();

            $table->foreign('performa_organisasi_id')->references('id')->on('performa_organisasi')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rencana_strategis');
    }
};
