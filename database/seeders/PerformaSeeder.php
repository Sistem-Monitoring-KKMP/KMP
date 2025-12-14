<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Koperasi;
use App\Models\Performa;
use Carbon\Carbon;

class PerformaSeeder extends Seeder
{
    public function run(): void
    {
        $koperasis = Koperasi::all();

        foreach ($koperasis as $koperasi) {

            // ✅ Loop 12 bulan terakhir (bulanan)
            for ($i = 0; $i < 12; $i++) {

                $periode = Carbon::now()
                    ->subMonths($i)
                    ->startOfMonth();

                Performa::factory()
                    ->periode($periode)
                    ->create([
                        'koperasi_id' => $koperasi->id,
                    ]);
            }
        }
    }
}
