<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('latar_belakang', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('pengurus_id');
            $table->enum('latarbelakang', ['koperasi','bisnis','ASN','militer/polisi','politik','organisasi'])->nullable();
            $table->timestamps();

            $table->foreign('pengurus_id')->references('id')->on('pengurus')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('latar_belakang');
    }
};
