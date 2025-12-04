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
        Schema::create('performa_bisnis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('performa_id');
            $table->integer('net_savings');
            $table->double('member_participation');
            $table->integer('total_sales');
            $table->double('growth_sales');
            $table->timestamps();

            $table->foreign('performa_id')->references('id')->on('performa')->cascadeOnDelete();
            
        });

        DB::statement("
                                    ALTER TABLE performa_bisnis
                                    ADD CONSTRAINT check_partisipasi
                                    CHECK (
                                        growth_sales BETWEEN 0 AND 1
                                        AND member_participation BETWEEN 0 AND 1
                                    )
                                ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performa_bisnis');
    }
};
