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
        Schema::create('prinsip_koperasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('performa_organisasi_id');
            $table->integer('sukarela_terbuka');
            $table->integer('demokratis');
            $table->integer('ekonomi');
            $table->integer('kemandirian');
            $table->integer('pendidikan');
            $table->integer('kerja_sama');
            $table->integer('kepedulian');
            $table->timestamps();

            $table->foreign('performa_organisasi_id')->references('id')->on('performa_organisasi')->cascadeOnDelete();
            
        });
        DB::statement("
                                    ALTER TABLE prinsip_koperasi
                                    ADD CONSTRAINT check_prinsip
                                    CHECK (
                                        sukarela_terbuka BETWEEN 1 AND 5
                                        AND demokratis BETWEEN 1 AND 5
                                        AND ekonomi BETWEEN 1 AND 5
                                        AND kemandirian BETWEEN 1 AND 5
                                        AND pendidikan BETWEEN 1 AND 5
                                        AND kerja_sama BETWEEN 1 AND 5
                                        AND kepedulian BETWEEN 1 AND 5
                                    )
                                ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prinsip_koperasis');
    }
};
