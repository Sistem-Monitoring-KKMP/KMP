<?php

namespace Database\Seeders;

use App\Models\PerformaOrganisasi;
use App\Models\RapatKoordinasi;
use Illuminate\Database\Seeder;

class RapatKoordinasiSeeder extends Seeder
{
    public function run(): void
    {
        PerformaOrganisasi::all()->each(function ($org) {

            RapatKoordinasi::updateOrCreate(
                ['performa_organisasi_id' => $org->id], // key unik 1–1
                RapatKoordinasi::factory()->make([
                    'performa_organisasi_id' => $org->id
                ])->toArray()
            );

        });
    }
}
