<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NeracaPassiva;
use App\Models\PerformaBisnis;

class NeracaPassivaSeeder extends Seeder
{
   
    public function run(): void
    {
        PerformaBisnis::all()->each(function ($bisnis) {

            NeracaPassiva::updateOrCreate(
                ['performa_bisnis_id' => $bisnis->id],
                NeracaPassiva::factory()->make([
                    'performa_bisnis_id' => $bisnis->id
                ])->toArray()
            );

        });
    }
}
