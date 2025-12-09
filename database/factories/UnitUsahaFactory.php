<?php

namespace Database\Factories;

use App\Models\UnitUsaha;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitUsahaFactory extends Factory
{
    protected $model = UnitUsaha::class;

    public function definition(): array
    {
        $volume = $this->faker->numberBetween(50_000_000, 500_000_000);
        $investasi = $this->faker->numberBetween(20_000_000, 300_000_000);
        $modal_kerja = $this->faker->numberBetween(10_000_000, 200_000_000);

        // Surplus dibuat sebagian besar positif
        $operasional = $this->faker->numberBetween(20_000_000, 300_000_000);
        $surplus = $volume - $operasional;

        // Cegah terlalu banyak negatif
        if ($surplus < -20_000_000) {
            $surplus = $this->faker->numberBetween(5_000_000, 50_000_000);
        }

        return [
            'performa_bisnis_id' => null, // diisi oleh seeder
            'unit' => null,               // diisi oleh seeder (unik)
            'volume_usaha' => $volume,
            'investasi' => $investasi,
            'model_kerja' => $modal_kerja,
            'surplus' => $surplus,
            'jumlah_sdm' => $this->faker->numberBetween(2, 25),
            'jumlah_anggota' => $this->faker->numberBetween(5, 20),
        ];
    }
}
