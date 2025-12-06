<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ksir', function (Blueprint $table) {
            $table->id('id');

            for ($i = 1; $i <= 10; $i++) {
                $table->enum("no$i", ['a', 'b', 'c'])->nullable();
            }

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ksir');
    }
};
