<?php

namespace Database\Factories;

use App\Models\RapatKoordinasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class RapatKoordinasiFactory extends Factory
{
    protected $model = RapatKoordinasi::class;

    public function definition(): array
    {
        $opsi = [
            'satu_minggu',
            'dua_minggu',
            'satu_bulan',
            'dua_bulan',
            'tiga_bulan_lebih'
        ];

        return [
            
            'performa_organisasi_id' => null,

            'rapat_pengurus' => $this->faker->randomElement($opsi),
            'rapat_pengawas' => $this->faker->randomElement($opsi),
            'rapat_gabungan' => $this->faker->randomElement($opsi),
            'rapat_pengurus_karyawan' => $this->faker->randomElement($opsi),
            'rapat_pengurus_anggota' => $this->faker->randomElement($opsi),
        ];
    }
}
