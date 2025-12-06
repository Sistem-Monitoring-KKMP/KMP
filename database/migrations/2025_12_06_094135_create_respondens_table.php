<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('responden', function (Blueprint $table) {
            $table->id('id');
            $table->string('responden')->nullable();
            $table->string('kontak_responden')->nullable();
            $table->string('enumerator')->nullable();
            $table->string('kontak_enumerator')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responden');
    }
};
