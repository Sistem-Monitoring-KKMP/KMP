<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Koperasi;
use App\Models\Pengurus;

class PengurusSeeder extends Seeder
{
    public function run(): void
    {
        $jabatanWajib = [
            'Ketua',
            'WakilBU',
            'WakilBA',
            'Sekretaris',
            'Bendahara',
            'KetuaPengawas',
            'Pengawas',
        ]; 

        $koperasis = Koperasi::all();

        foreach ($koperasis as $koperasi) {

            
            foreach ($jabatanWajib as $jabatan) {
                Pengurus::factory()->create([
                    'koperasi_id' => $koperasi->id,
                    'jabatan' => $jabatan,
                ]);
            }

            
            if (rand(0, 1)) {
                Pengurus::factory()->create([
                    'koperasi_id' => $koperasi->id,
                    'jabatan' => 'GeneralManager',
                ]);
            }

            
            // Pengurus::factory(rand(0, 3))->create([
            //     'koperasi_id' => $koperasi->id,
            // ]);
        }
    }
}
