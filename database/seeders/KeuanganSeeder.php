<?php

namespace Database\Seeders;
use App\Models\Keuangan;
use App\Models\PerformaBisnis;
use Illuminate\Database\Seeder;

class KeuanganSeeder extends Seeder
{
    public function run(): void
    {   
        PerformaBisnis::all()->each(function ($bisnis) {

            Keuangan::updateOrCreate(
                ['performa_bisnis_id' => $bisnis->id],
                Keuangan::factory()->make([
                    'performa_bisnis_id' => $bisnis->id
                ])->toArray()
            );

        });
    }
}
