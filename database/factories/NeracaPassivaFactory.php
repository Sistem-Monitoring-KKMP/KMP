<?php

namespace Database\Factories;

use App\Models\NeracaPassiva;
use Illuminate\Database\Eloquent\Factories\Factory;

class NeracaPassivaFactory extends Factory
{
    protected $model = NeracaPassiva::class;

    public function definition(): array
    {
        // Komponen Hutang
        $hutang_lancar = $this->faker->numberBetween(5_000_000, 150_000_000);
        $hutang_jangka_panjang = $this->faker->numberBetween(10_000_000, 400_000_000);

        $total_hutang = $hutang_lancar + $hutang_jangka_panjang;

        // Modal selalu lebih besar dari hutang agar neraca sehat
        $modal = $this->faker->numberBetween(100_000_000, 800_000_000);

        // Total Passiva
        $total_passiva = $total_hutang + $modal;

        return [
            'performa_bisnis_id' => null, // diisi via seeder

            'hutang_lancar' => $hutang_lancar,
            'hutang_jangka_panjang' => $hutang_jangka_panjang,
            'total_hutang' => $total_hutang,

            'modal' => $modal,
            'total_passiva' => $total_passiva,
        ];
    }
}
