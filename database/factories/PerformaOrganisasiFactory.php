<?php

namespace Database\Factories;

use App\Models\Performa;
use App\Models\PerformaOrganisasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerformaOrganisasiFactory extends Factory
{
    protected $model = PerformaOrganisasi::class;

    public function definition(): array
    {
        // Batasan jumlah
        $jumlahPengurus  = $this->faker->numberBetween(3, 8);
        $jumlahPengawas  = $this->faker->numberBetween(2, 6);
        $jumlahKaryawan  = $this->faker->numberBetween(2, 20);

        // Total anggota tetap 50
        $totalAnggota = $this->faker->numberBetween(50, 60);
        $anggotaAktif = $this->faker->numberBetween(40, 50);
        $anggotaTidakAktif = $totalAnggota - $anggotaAktif;

        return [
            'performa_id' => null,

            'responden_id' => null,

            'jumlah_pengurus' => $jumlahPengurus,
            'jumlah_pengawas' => $jumlahPengawas,
            'jumlah_karyawan' => $jumlahKaryawan,


            'total_anggota' => $totalAnggota,
            'anggota_aktif' => $anggotaAktif,
            'anggota_tidak_aktif' => $anggotaTidakAktif,

            'general_manager' => $this->faker->boolean(40),
            'rapat_tepat_waktu' => $this->faker->boolean(90),
            'rapat_luar_biasa' => $this->faker->boolean(25),
            'pergantian_pengurus' => $this->faker->boolean(10),
            'pergantian_pengawas' => $this->faker->boolean(10),
        ];
    }
}
