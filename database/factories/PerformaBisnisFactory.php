<?php

namespace Database\Factories;

use App\Models\Performa;
use App\Models\Responden;
use App\Models\PerformaBisnis;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerformaBisnisFactory extends Factory
{
    protected $model = PerformaBisnis::class;

    public function definition(): array
    {
        return [
            // 1–1 langsung ke performa, bukan random duplicate
            'performa_id' => Performa::factory(),

            'proyeksi_rugi_laba' => $this->faker->boolean(60),
            'proyeksi_arus_kas' => $this->faker->boolean(60),

            'responden_id' => Responden::inRandomOrder()->value('id'),
        ];
    }
}

