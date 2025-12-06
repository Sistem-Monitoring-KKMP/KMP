<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengurus', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('koperasi_id');
            $table->string('nama');
            $table->enum('jabatan', ['Ketua','WakilBU','WakilBA','Sekretaris','Bendahara','KetuaPengawas','Pengawas','GeneralManager']);
            $table->enum('jenis_kelamin', ['L','P']);
            $table->integer('usia')->nullable();
            $table->boolean('pendidikan_koperasi')->default(false);
            $table->boolean('pendidikan_ekonomi')->default(false);
            $table->boolean('pelatihan_koperasi')->default(false);
            $table->boolean('pelatihan_bisnis')->default(false);
            $table->boolean('pelatihan_lainnya')->default(false);
            $table->enum('tingkat_pendidikan', ['sd','sltp','slta','diploma','sarjana','pascasarjana'])->nullable();
            $table->enum('keaktifan_kkmp', ['aktif','cukup aktif','kurang aktif'])->nullable();
            $table->timestamps();

            $table->foreign('koperasi_id')->references('id')->on('koperasi')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengurus');
    }
};
