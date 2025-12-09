<?php

namespace Database\Seeders;

use App\Models\Pelatihan;
use App\Models\PerformaOrganisasi;
use Illuminate\Database\Seeder;

class PelatihanSeeder extends Seeder
{
    public function run(): void
    {
        $enumPelatihan = [
            'Pengurus',
            'Pengawas',
            'GeneralManager',
            'Karyawan',
            'Anggota',
            'NonAnggota'
        ];

        PerformaOrganisasi::all()->each(function ($org) use ($enumPelatihan) {

            // Tentukan secara acak enum mana saja yang dimiliki koperasi ini
            $pelatihanDimiliki = collect($enumPelatihan)
                ->random(rand(1, count($enumPelatihan))); 

            foreach ($pelatihanDimiliki as $jenis) {

                Pelatihan::updateOrCreate(
                    [
                        'performa_organisasi_id' => $org->id,
                        'pelatihan' => $jenis,   
                    ],
                    Pelatihan::factory()->make([
                        'performa_organisasi_id' => $org->id,
                        'pelatihan' => $jenis,
                        'akumulasi' => rand(1, 20),
                    ])->toArray()
                );

            }
        });
    }
}
