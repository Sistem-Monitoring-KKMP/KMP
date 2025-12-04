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
        Schema::create('pengurus', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('koperasi_id');
        $table->string('ketua');
        $table->string('wakil_bu');
        $table->string('wakil_ba');
        $table->string('sekretaris');
        $table->string('bendahara');
        $table->timestamps();

        $table->foreign('koperasi_id')->references('id')->on('koperasi')->cascadeOnDelete();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penguruses');
    }
};
