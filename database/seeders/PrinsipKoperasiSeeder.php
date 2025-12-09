<?php

namespace Database\Seeders;

use App\Models\PerformaOrganisasi;
use App\Models\PrinsipKoperasi;
use Illuminate\Database\Seeder;

class PrinsipKoperasiSeeder extends Seeder
{
    public function run(): void
    {
        PerformaOrganisasi::all()->each(function ($org) {

            PrinsipKoperasi::updateOrCreate(
                [
                    'performa_organisasi_id' => $org->id, 
                ],
                PrinsipKoperasi::factory()->make([
                    'performa_organisasi_id' => $org->id,
                ])->toArray()
            );

        });
    }
}
