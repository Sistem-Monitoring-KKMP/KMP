<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hubungan_lembaga', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('performa_bisnis_id');
            $table->enum('lembaga', [
                'Perbankan Pemerintah','Perbankan Swasta','keuangan Non-Bank','BUMN','Daerah','Swasta','Masyarakat'
            ]);
            $table->integer('kemudahan')->nullable();
            $table->integer('intensitas')->nullable();
            $table->integer('dampak')->nullable();
            $table->timestamps();

            $table->foreign('performa_bisnis_id')->references('id')->on('performa_bisnis')->cascadeOnDelete();
        });

        // add check constraint if supported (MySQL 8+, Postgres)
        DB::statement("ALTER TABLE hubungan_lembaga ADD CONSTRAINT check_hubungan CHECK (kemudahan BETWEEN 1 AND 4 AND intensitas BETWEEN 1 AND 4 AND dampak BETWEEN 1 AND 4)");
    }

    public function down(): void
    {
        Schema::dropIfExists('hubungan_lembaga');
    }
};
