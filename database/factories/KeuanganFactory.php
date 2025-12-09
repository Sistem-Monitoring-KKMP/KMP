<?php

namespace Database\Factories;

use App\Models\Keuangan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeuanganFactory extends Factory
{
    protected $model = Keuangan::class;

    public function definition(): array
    {
        
        $omset = $this->faker->numberBetween(50_000_000, 500_000_000);

        
        $isNegative = $this->faker->boolean(10); 

        if ($isNegative) {
            
            $operasional = $this->faker->numberBetween(
                $omset,
                (int) ($omset * 1.1) 
            );
        } else {
            
            $operasional = $this->faker->numberBetween(
                (int) ($omset * 0.6),
                (int) ($omset * 0.95)
            );
        }

        $surplus = $omset - $operasional;

        return [
            'performa_bisnis_id' => null, 

            'pinjaman_bank'   => $this->faker->numberBetween(10_000_000, 200_000_000),
            'investasi'       => $this->faker->numberBetween(5_000_000, 150_000_000),
            'modal_kerja'     => $this->faker->numberBetween(10_000_000, 300_000_000),
            'simpanan_anggota'=> $this->faker->numberBetween(5_000_000, 100_000_000),
            'hibah'           => $this->faker->boolean(20)
                                    ? $this->faker->numberBetween(1_000_000, 50_000_000)
                                    : 0,

            'omset'       => $omset,
            'operasional' => $operasional,
            'surplus'     => $surplus,
        ];
    }
}
