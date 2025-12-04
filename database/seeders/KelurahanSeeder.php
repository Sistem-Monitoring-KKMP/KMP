<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelurahan')->insert([
            // Bogor Barat (1)
            ['id' => 1, 'nama' => 'Balungbangjaya'],
            ['id' => 2, 'nama' => 'Bubulak'],
            ['id' => 3, 'nama' => 'Cilendek Barat'],
            ['id' => 4, 'nama' => 'Cilendek Timur'],
            ['id' => 5, 'nama' => 'Curug'],
            ['id' => 6, 'nama' => 'Curugmekar'],
            ['id' => 7, 'nama' => 'Gunungbatu'],
            ['id' => 8, 'nama' => 'Loji'],
            ['id' => 9, 'nama' => 'Margajaya'],
            ['id' => 10, 'nama' => 'Menteng'],
            ['id' => 11, 'nama' => 'Pasirjaya'],
            ['id' => 12, 'nama' => 'Pasirkuda'],
            ['id' => 13, 'nama' => 'Pasirmulya'],
            ['id' => 14, 'nama' => 'Semplak'],
            ['id' => 15, 'nama' => 'Sindangbarang'],
            ['id' => 16, 'nama' => 'Situgede'],

            // Bogor Selatan (2)
            ['id' => 17, 'nama' => 'Batutulis'],
            ['id' => 18, 'nama' => 'Bojongkerta'],
            ['id' => 19, 'nama' => 'Bondongan'],
            ['id' => 20, 'nama' => 'Cikaret'],
            ['id' => 21, 'nama' => 'Cipaku'],
            ['id' => 22, 'nama' => 'Empang'],
            ['id' => 23, 'nama' => 'Genteng'],
            ['id' => 24, 'nama' => 'Harjasari'],
            ['id' => 25, 'nama' => 'Kertamaya'],
            ['id' => 26, 'nama' => 'Lawanggintung'],
            ['id' => 27, 'nama' => 'Muarasari'],
            ['id' => 28, 'nama' => 'Mulyaharja'],
            ['id' => 29, 'nama' => 'Pakuan'],
            ['id' => 30, 'nama' => 'Pamoyanan'],
            ['id' => 31, 'nama' => 'Rancamaya'],
            ['id' => 32, 'nama' => 'Ranggamekar'],

            // Bogor Tengah (3)
            ['id' => 33, 'nama' => 'Babakan'],
            ['id' => 34, 'nama' => 'Babakanpasar'],
            ['id' => 35, 'nama' => 'Cibogor'],
            ['id' => 36, 'nama' => 'Ciwaringin'],
            ['id' => 37, 'nama' => 'Gudang'],
            ['id' => 38, 'nama' => 'Kebonkelapa'],
            ['id' => 39, 'nama' => 'Pabaton'],
            ['id' => 40, 'nama' => 'Paledang'],
            ['id' => 41, 'nama' => 'Panaragan'],
            ['id' => 42, 'nama' => 'Sempur'],
            ['id' => 43, 'nama' => 'Tegallega'],

            // Bogor Timur (4)
            ['id' => 44, 'nama' => 'Baranangsiang'],
            ['id' => 45, 'nama' => 'Katulampa'],
            ['id' => 46, 'nama' => 'Sindangrasa'],
            ['id' => 47, 'nama' => 'Sindangsari'],
            ['id' => 48, 'nama' => 'Sukasari'],
            ['id' => 49, 'nama' => 'Tajur'],

            // Bogor Utara (5)
            ['id' => 50, 'nama' => 'Bantar Jati'],
            ['id' => 51, 'nama' => 'Cibuluh'],
            ['id' => 52, 'nama' => 'Ciluar'],
            ['id' => 53, 'nama' => 'Cimahpar'],
            ['id' => 54, 'nama' => 'Ciparigi'],
            ['id' => 55, 'nama' => 'Kedunghalang'],
            ['id' => 56, 'nama' => 'Tanahbaru'],
            ['id' => 57, 'nama' => 'Tegalgundil'],

            // Tanah Sareal (6)
            ['id' => 58, 'nama' => 'Cibadak'],
            ['id' => 59, 'nama' => 'Kayumanis'],
            ['id' => 60, 'nama' => 'Kebonpedes'],
            ['id'=> 61,'nama' => 'Kedungbadak'],
            ['id'=> 62,'nama' => 'Kedungjaya'],
            ['id'=> 63,'nama' => 'Kedungwaringin'],
            ['id'=> 64,'nama' => 'Kencana'],
            ['id'=> 65,'nama' => 'Mekarwangi'],
            ['id'=> 66,'nama' => 'Sukadamai'],
            ['id'=> 67,'nama' => 'Sukaresmi'],
            ['id'=> 68,'nama' => 'Tanahsareal'],
        ]);
    }
}
