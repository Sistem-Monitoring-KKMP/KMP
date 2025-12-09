<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $koperasi = [
            ['nama' => 'Koperasi Kelurahan Merah Putih Tegal Gundil', 'kontak' => '8975231253',],
            ['nama' => 'Koperasi Kelurahan Merah Putih Tanah Baru Bogor Utara', 'kontak' => '8129406339'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Ciluar', 'kontak' => '819110896407'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Cimahpar', 'kontak' => '81932997950'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Bantar Jati Bogor Utara', 'kontak' => '82210056950'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Kedung Halang', 'kontak' => '88211221552'],
            ['nama' => 'KOPERASI KELURAHAN MERAH PUTIH CIBULUH BOGOR UTARA', 'kontak' => '81387424090'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Ciparigi', 'kontak' => '87874169612'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Tajur Kecamatan Bogor Timur', 'kontak' => '8888351778'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Sindangsari', 'kontak' => '81295093405'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Katulampa', 'kontak' => '81317792810'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Sukasari Kecamatan Bogor Timur', 'kontak' => '87873370888'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Barangsiang', 'kontak' => null],
            ['nama' => 'Koperasi Kelurahan Merah Putih Sindang rasa', 'kontak' => '85718516768'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Tegal Lega Kecamatan Bogor Tengah', 'kontak' => null],
            ['nama' => 'Koperasi Kelurahan Merah Putih Cibogor Kecamatan Bogor Tengah', 'kontak' => '85882709701'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Ciwaringin Kecamatan Bogor Tengah', 'kontak' => '81383940354'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Sempur Kecamatan Bogr Tengah', 'kontak' => '87827763510'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Babakan Kecamatan Bogr Tengah', 'kontak' => '87831188437'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Pabaton Kecamatan Bogr Tengah', 'kontak' => null],
            ['nama' => 'Koperasi Kelurahan Merah Putih Paledang Kecamatan Bogr Tengah', 'kontak' => null],
            ['nama' => 'Koperasi Kelurahan Merah Putih Panaragan Kecamatan Bogr Tengah', 'kontak' => '85157864642'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Babakan pasar Kecamatan Bogr Tengah', 'kontak' => '87872303017'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Gudang Kecamatan Bogr Tengah', 'kontak' => null],
            ['nama' => 'Koperasi Kelurahan Merah Putih Kebon Kalapa Kecamatan Bogr Tengah', 'kontak' => '82150816321'],
            ['nama' => 'KOPERASI KELURAHAN MERAH PUTIH MARGAJAYA KECAMATAN BOGOR BARAT', 'kontak' => '81282390902'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Loji Kecamatan Bogor Barat', 'kontak' => '085780228011'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Timur', 'kontak' => '81245199472'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Semplak', 'kontak' => null],
            ['nama' => 'Koperasi Kelurahan Merah Putih Gunung Batu Kecamatan Bogor Barat', 'kontak' => '895395456344'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Curug', 'kontak' => '81310528841'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Pasir Kuda', 'kontak' => '81314700534'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Barat Kecamatan Bogor Barat', 'kontak' => '82261650076'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Pasir Mulya', 'kontak' => '81289667683'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Situ Gede', 'kontak' => '82123722975'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Sindangbarang', 'kontak' => '89601258928'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Balumbang Jaya', 'kontak' => '852819520245'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Curug Mekar', 'kontak' => '88973098852'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Bubulak', 'kontak' => '81297310273'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Menteng Kecamatan Bogor Barat', 'kontak' => '81392281980'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Pasir Jaya Kecamatan Bogor Barat', 'kontak' => '8589161341'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Empang Kecamatan Bogor Seletan', 'kontak' => '85716629424'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Bojongkerta', 'kontak' => '85798803115'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Lawanggintung', 'kontak' => '89618294439'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Kertamaya', 'kontak' => '87882665762'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Pamoyanan Kecamatan Bogor Seletan', 'kontak' => '81574747442'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Mulyaharja', 'kontak' => '81282831333'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Cikaret Kecamatan Bogor Seletan', 'kontak' => '81584035552'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Rangga Mekar', 'kontak' => '87770036039'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Cipaku Kecamatan Bogor Seletan', 'kontak' => '85881427578'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Muarasari', 'kontak' => '81380904221'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Batutulis', 'kontak' => '81584149255'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Bondongan', 'kontak' => '87872092250'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Harjasari', 'kontak' => '85771632642'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Genteng Kecamatan Bogor Seletan', 'kontak' => '8111149800'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Pakuan', 'kontak' => '87822865815'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Rancamaya Kecamatan Bogor Seletan', 'kontak' => '85777444457'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Kedung jaya Kecamatan Tanah Sareal', 'kontak' => '85777795963'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Kebon Pedes', 'kontak' => '83831964437'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Kedung badak', 'kontak' => '8121070899'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Sukadamai Kecamatan Tanah Sareal', 'kontak' => '0895704263976'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Sukaresmi Kecamatan Tanah Sareal', 'kontak' => '85215538780'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Kayumanis', 'kontak' => '81297432811'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Tanah Sareal Kecamatan Tanah Sareal', 'kontak' => '85210107955'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Mekarwangi Tanah Sareal', 'kontak' => '89670282969'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Cibadak', 'kontak' => '8151615403'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Kencana Kecamatan Tanah Sareal', 'kontak' => '8179120747'],
            ['nama' => 'Koperasi Kelurahan Merah Putih Kedung Waringin', 'kontak' => '81319790067'],
        ];

        DB::table('koperasi')->insert($koperasi);
    }
}
