<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(
     [
                KecamatanSeeder::class,
                KelurahanSeeder::class,
                KoperasiSeeder::class,
                LokasiSeeder::class,
                PengurusSeeder::class,
                PerformaSeeder::class,
                PerformaBisnisSeeder::class,
                PerformaOrganisasiSeeder::class,
                RapatKoordinasiSeeder::class,
                PelatihanSeeder::class,
                PrinsipKoperasiSeeder::class,
                NeracaAktivaSeeder::class,
                NeracaPassivaSeeder::class,
                UnitUsahaSeeder::class,
                KeuanganSeeder::class,
                UserSeeder::class
                

                
            ]
        );
    }
}
