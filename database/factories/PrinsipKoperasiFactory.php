<?php

namespace Database\Factories;

use App\Models\PrinsipKoperasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrinsipKoperasiFactory extends Factory
{
    protected $model = PrinsipKoperasi::class;

    public function definition(): array
    {
        return [
            
            'performa_organisasi_id' => null,

            
            'sukarela_terbuka' => $this->faker->numberBetween(1, 5),
            'demokratis'       => $this->faker->numberBetween(1, 5),
            'ekonomi'          => $this->faker->numberBetween(1, 5),
            'kemandirian'      => $this->faker->numberBetween(1, 5),
            'pendidikan'       => $this->faker->numberBetween(1, 5),
            'kerja_sama'       => $this->faker->numberBetween(1, 5),
            'kepedulian'       => $this->faker->numberBetween(1, 5),
        ];
    }
}
