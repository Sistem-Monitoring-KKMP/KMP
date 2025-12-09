<?php

namespace Database\Seeders;

use App\Models\Performa;
use App\Models\PerformaOrganisasi;
use Illuminate\Database\Seeder;

class PerformaOrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        Performa::all()->each(function ($performa) {

            // Cegah duplikasi data 1–1
            PerformaOrganisasi::firstOrCreate(
                ['performa_id' => $performa->id],
                PerformaOrganisasi::factory()->make([
                    'performa_id' => $performa->id
                ])->toArray()
            );

        });
    }
}
