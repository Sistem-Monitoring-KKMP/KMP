<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NeracaAktiva;
use App\Models\PerformaBisnis;

class NeracaAktivaSeeder extends Seeder
{
    
    public function run(): void
    {
        PerformaBisnis::all()->each(function ($bisnis) {

            NeracaAktiva::updateOrCreate(
                ['performa_bisnis_id' => $bisnis->id],
                NeracaAktiva::factory()->make([
                    'performa_bisnis_id' => $bisnis->id
                ])->toArray()
            );

        });
    }
}
