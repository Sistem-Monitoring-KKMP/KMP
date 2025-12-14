<?php

namespace Database\Factories;

use App\Models\Pelatihan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PelatihanFactory extends Factory
{
    protected $model = Pelatihan::class;

    public function definition(): array
    {
        return [
           
            'performa_organisasi_id' => null,

            
            'pelatihan' => null,

            
            'akumulasi' => $this->faker->numberBetween(1, 20),
        ];
    }
}
