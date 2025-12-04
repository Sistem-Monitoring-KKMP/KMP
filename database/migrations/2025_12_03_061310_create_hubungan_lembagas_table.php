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
        Schema::create('hubungan_lembaga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('performa_bisnis_id');
            $table->integer('kemudahan');
            $table->integer('intensitas');
            $table->integer('dampak');
            $table->timestamps();

            $table->foreign('performa_bisnis_id')->references('id')->on('performa_bisnis')->cascadeOnDelete();
            
});
            DB::statement("
                                    ALTER TABLE hubungan_lembaga
                                    ADD CONSTRAINT check_hubungan
                                    CHECK (
                                        kemudahan BETWEEN 1 AND 5
                                        AND intensitas BETWEEN 1 AND 5
                                        AND dampak BETWEEN 1 AND 5
                                    )
                                ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hubungan_lembagas');
    }
};
