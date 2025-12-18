<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'nama' => 'Bogor Barat'],
            ['id' => 2, 'nama' => 'Bogor Selatan'],
            ['id' => 3, 'nama' => 'Bogor Tengah'],
            ['id' => 4, 'nama' => 'Bogor Timur'],
            ['id' => 5, 'nama' => 'Bogor Utara'],
            ['id' => 6, 'nama' => 'Tanah Sareal'],
        ];

        foreach ($data as $row) {
            DB::table('kecamatan')->updateOrInsert(
                ['id' => $row['id']],   
                ['nama' => $row['nama']] 
            );
        }
    }
}
