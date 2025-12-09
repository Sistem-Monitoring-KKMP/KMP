<?php

namespace Database\Factories;

use App\Models\NeracaAktiva;
use Illuminate\Database\Eloquent\Factories\Factory;

class NeracaAktivaFactory extends Factory
{
    protected $model = NeracaAktiva::class;

    public function definition(): array
    {
        // Komponen Aktiva Lancar
        $kas     = $this->faker->numberBetween(1_000_000, 50_000_000);
        $piutang = $this->faker->numberBetween(5_000_000, 150_000_000);

        $aktiva_lancar = $kas + $piutang;

        // Komponen Aktiva Tetap
        $tanah     = $this->faker->numberBetween(50_000_000, 500_000_000);
        $bangunan  = $this->faker->numberBetween(100_000_000, 1_000_000_000);
        $kendaraan = $this->faker->numberBetween(20_000_000, 300_000_000);

        $aktiva_tetap = $tanah + $bangunan + $kendaraan;

        // Total Aktiva
        $total_aktiva = $aktiva_lancar + $aktiva_tetap;

        return [
            'performa_bisnis_id' => null, // diisi dari seeder

            'kas' => $kas,
            'piutang' => $piutang,
            'aktiva_lancar' => $aktiva_lancar,

            'tanah' => $tanah,
            'bangunan' => $bangunan,
            'kendaraan' => $kendaraan,
            'aktiva_tetap' => $aktiva_tetap,

            'total_aktiva' => $total_aktiva,
        ];
    }
}
