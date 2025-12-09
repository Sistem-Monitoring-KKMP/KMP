<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PerformaBisnis;
use App\Models\UnitUsaha;

class UnitUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarUnit = [
    'Gerai Sembako',
    'Klinik Desa',
    'Gerai Obat',
    'Jasa Logistik',
    'Gudang',
    'Simpan Pinjam',
    'Unit Lain',
    ];

    PerformaBisnis::all()->each(function ($bisnis) use ($daftarUnit) {

        // ✅ 80% hanya 1 unit, 20% bisa 2–4 unit
        $jumlahUnit = rand(1, 10) <= 8 ? 1 : rand(2, 4);

        // Ambil unit secara unik
        $unitTerpilih = collect($daftarUnit)->shuffle()->take($jumlahUnit);

        foreach ($unitTerpilih as $unit) {

            UnitUsaha::updateOrCreate(
                [
                    'performa_bisnis_id' => $bisnis->id,
                    'unit' => $unit, // ✅ unik per performa_bisnis
                ],
                UnitUsaha::factory()->make([
                    'performa_bisnis_id' => $bisnis->id,
                    'unit' => $unit,
                ])->toArray()
            );
        }
    });
    }
}
