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
        Schema::create('performa_organisasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('performa_id');
            $table->integer('jumlah_anggota');
            $table->integer('jumlah_karwayan');
            $table->double('chairmen_activeness');
            $table->double('control_effectiveness');
            $table->integer('external_visit');
            $table->timestamps();

            $table->foreign('performa_id')->references('id')->on('performa')->cascadeOnDelete();
            
        });
            DB::statement("
            ALTER TABLE performa_organisasi
            ADD CONSTRAINT check_performa
            CHECK (
                chairmen_activeness BETWEEN 0 AND 1
                AND control_effectiveness BETWEEN 0 AND 1
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performa_organisasis');
    }
};
