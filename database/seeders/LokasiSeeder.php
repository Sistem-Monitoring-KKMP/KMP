<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lokasi = [
            // Bogor Utara
            ['koperasi_id' => 1, 'kelurahan_id' => 57, 'kecamatan_id' => 5, 'alamat' => 'Jl.Arzimar II no. 3', 'latitude' => -6.576383, 'longitude' => 106.812175],
            ['koperasi_id' => 2, 'kelurahan_id' => 56, 'kecamatan_id' => 5, 'alamat' => 'Jl. Pangeran Sogiri No 374 Rt.04/02', 'latitude' => -6.560813, 'longitude' => 106.822716],
            ['koperasi_id' => 3, 'kelurahan_id' => 52, 'kecamatan_id' => 5, 'alamat' => 'Jl. Sukaraja No. 300 Rt 004 / RW 001', 'latitude' => -6.551046306382286, 'longitude' => 106.82934703768514],
            ['koperasi_id' => 4, 'kelurahan_id' => 53, 'kecamatan_id' => 5, 'alamat' => 'Jl. Guru Muhtar Nno. 27 Rt.001/016', 'latitude' => -6.582465202862697, 'longitude' => 106.83316643768556],
            ['koperasi_id' => 5, 'kelurahan_id' => 50, 'kecamatan_id' => 5, 'alamat' => 'Bantarjati Atas Rt. 02 Rw. 02', 'latitude' => -6.583152321651485, 'longitude' => 106.80268033351348],
            ['koperasi_id' => 6, 'kelurahan_id' => 55, 'kecamatan_id' => 5, 'alamat' => 'Kantor Kelurahan Kedung Halang Jl. Raya Kedung Halang Rt.03 Rw.07', 'latitude' => -6.5543446540666315, 'longitude' => 106.80895786467018],
            ['koperasi_id' => 7, 'kelurahan_id' => 51, 'kecamatan_id' => 5, 'alamat' => 'Jl. Pangeran shogiri RT 01/ RW 04', 'latitude' => -6.587425307930547, 'longitude' => 106.82091459923609],
            ['koperasi_id' => 8, 'kelurahan_id' => 54, 'kecamatan_id' => 5, 'alamat' => 'Komplek Kantor Kelurahan ciparigi Jl. Boelevard1 Villa Bogor Indah Blok CC RT.06/ RW 13 Kel. Ciparagi', 'latitude' => -6.543433621891936, 'longitude' => 106.81080425487933],

            // Bogor Timur
            ['koperasi_id' => 9, 'kelurahan_id' => 49, 'kecamatan_id' => 4, 'alamat' => 'Gg. Bale Desa Rt.001/005', 'latitude' => -6.630336695244012, 'longitude' => 106.82504376652172],
            ['koperasi_id' => 10, 'kelurahan_id' => 47, 'kecamatan_id' => 4, 'alamat' => 'Jl. Raya Wangun No. 332 Rt.05/01 Kel. Sindangsari Kec. Bogor Timur', 'latitude' => -6.651331988141461, 'longitude' => 106.84479392679648],
            ['koperasi_id' => 11, 'kelurahan_id' => 45, 'kecamatan_id' => 4, 'alamat' => 'Kantor Kelurahan Katulampa Jl. R3 Rt.3/1', 'latitude' => -6.618866878422808, 'longitude' => 106.82765387272752],
            ['koperasi_id' => 12, 'kelurahan_id' => 48, 'kecamatan_id' => 4, 'alamat' => 'Jl. Sukasari 1 No. 07 RT.04 Rw.02', 'latitude' => -6.617009474001576, 'longitude' => 106.81292155117822],
            ['koperasi_id' => 13, 'kelurahan_id' => 44, 'kecamatan_id' => 4, 'alamat' => 'Jl. Riau No. 13 Kel. Baranangsiang Kec. Bogor Timur Kota Bogor', 'latitude' => -6.606187068645499, 'longitude' => 106.80607430884982],
            ['koperasi_id' => 14, 'kelurahan_id' => 46, 'kecamatan_id' => 4, 'alamat' => 'Kp. Muara tegal Rt.02/01 Kel. Sindang Rasa Kec. Bogor Timur Kota Bogor', 'latitude' => -6.641399511291307, 'longitude' => 106.83765694489067],

            // Bogor Tengah
            ['koperasi_id' => 15, 'kelurahan_id' => 43, 'kecamatan_id' => 3, 'alamat' => "Jalan KPP Baranangsiang 3 Nomor 2, Rukun Tetangga 004, Rukun Warga 008, Kelurahan Tegallega, Kecamatan Bogor Tengah, Kota Bogor, Provinsi Jawa Barat.", 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 16, 'kelurahan_id' => 35, 'kecamatan_id' => 3, 'alamat' => 'Jl. RE Martadinata No. 5', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 17, 'kelurahan_id' => 36, 'kecamatan_id' => 3, 'alamat' => 'Jl. RE Martadinata No. 32 Rt.01/11', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 18, 'kelurahan_id' => 42, 'kecamatan_id' => 3, 'alamat' => 'Jl. Sempur No. 33 Rt.03/01', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 19, 'kelurahan_id' => 33, 'kecamatan_id' => 3, 'alamat' => 'jl. Malabar Ujung No. 7 Rt.02/07', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 20, 'kelurahan_id' => 39, 'kecamatan_id' => 3, 'alamat' => "Jalan Tel epon Nomor 2, Rukun Tetangga 002, Rukun Warga 001, Kelurahan Pabaton, Kecamatan Bogor Tengah, Kota Bogor, Provinsi Jawa Barat.", 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 21, 'kelurahan_id' => 40, 'kecamatan_id' => 3, 'alamat' => "Jalan Selot Nomor 18, Kelurahan Paledang, Kecamatan Bogor Tengah, Kota Bogor, Provinsi Jawa Barat.", 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 22, 'kelurahan_id' => 41, 'kecamatan_id' => 3, 'alamat' => 'Jl. Panaragan Kidul No. 3', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 23, 'kelurahan_id' => 34, 'kecamatan_id' => 3, 'alamat' => 'Jl. Roda 1 No.2 Rt.03/08', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 24, 'kelurahan_id' => 37, 'kecamatan_id' => 3, 'alamat' => "Jalan padasuka Nomor 5, Rt 001, Rw 012, Kelurahan Gudang, Kec. Bogor Tengah, Kota Bogor, provinsi Jawa Barat.", 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 25, 'kelurahan_id' => 38, 'kecamatan_id' => 3, 'alamat' => 'Jl. Semboja No. 2', 'latitude' => null, 'longitude' => null],

            // Bogor Barat
            ['koperasi_id' => 26, 'kelurahan_id' => 9, 'kecamatan_id' => 1, 'alamat' => 'Jl. Raya dramaga Km7', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 27, 'kelurahan_id' => 8, 'kecamatan_id' => 1, 'alamat' => 'Kelurahan Loji/ Jalan Siaga Komplek Pertanian No.49 Kecamatan Bogor Barat', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 28, 'kelurahan_id' => 4, 'kecamatan_id' => 1, 'alamat' => 'Jl.  Gg Masjid No. 56', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 29, 'kelurahan_id' => 14, 'kecamatan_id' => 1, 'alamat' => "Jalan HT. Sobari KM. 9, -- Rukun Tetangga 004 Rukun Warga 001, Kelurahan Semplak, Kecamatan Bogor Barat, Kota Bogor, Provinsi Jawa Barat.", 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 30, 'kelurahan_id' => 7, 'kecamatan_id' => 1, 'alamat' => 'Kantor Kelurahan Gunung Batu Jalan Ishak Djuarsa No 253, Kelurahan Gunung Batu, Kecamatan Bogor Barat.', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 31, 'kelurahan_id' => 5, 'kecamatan_id' => 1, 'alamat' => 'Jl. Desa Curug No 08 Rt.003/002, Kel.Curug,kec.Bogor Barat,Kota Bogor.', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 32, 'kelurahan_id' => 12, 'kecamatan_id' => 1, 'alamat' => 'Jl. Aria Surialaga No. 29', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 33, 'kelurahan_id' => 3, 'kecamatan_id' => 1, 'alamat' => 'Jl. Brigjen Saptaji Hadiprawira No 70 , Kelurahan  Barat, Kec Bogor Barat, Kota Bogor', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 34, 'kelurahan_id' => 13, 'kecamatan_id' => 1, 'alamat' => 'jl. RE Abdulallah No.16 Bogor 16117', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 35, 'kelurahan_id' => 16, 'kecamatan_id' => 1, 'alamat' => 'Jl. Tambakan No. 56 RT 01 RW 05', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 36, 'kelurahan_id' => 15, 'kecamatan_id' => 1, 'alamat' => 'Jl. HM Syarifuddin No. 25', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 37, 'kelurahan_id' => 1, 'kecamatan_id' => 1, 'alamat' => 'Jl. Balumbang Jaya Nomor 1 Kelurahan Balumbang Jaya Kecamatan Bogor Barat Kota Bogor', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 38, 'kelurahan_id' => 6, 'kecamatan_id' => 1, 'alamat' => 'Jalan Raya Abdulah Bin Nuh', 'latitude' => null, 'longitude' => null],

            // Bogor Selatan (koperasi_id 39–52)
            ['koperasi_id' => 39, 'kelurahan_id' => 18, 'kecamatan_id' => 2, 'alamat' => 'Jl. Pahlawan No.144 Rt. 001/008', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 40, 'kelurahan_id' => 21, 'kecamatan_id' => 2, 'alamat' => 'Jl. Bojong Pesantren RT 04/03 Kelurahan Bojongkerta Kecamatan Bogor Selatan Kota Bogor', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 41, 'kelurahan_id' => 26, 'kecamatan_id' => 2, 'alamat' => 'jl lawanggintung no 30 rt 004/003', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 42, 'kelurahan_id' => 25, 'kecamatan_id' => 2, 'alamat' => 'Margabhakti rt 3 / 01', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 43, 'kelurahan_id' => 30, 'kecamatan_id' => 2, 'alamat' => 'jl RE soemantadiredja no 3 rt001/001', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 44, 'kelurahan_id' => 28, 'kecamatan_id' => 2, 'alamat' => 'jl. cibeureum no 13 kel. mulyaharja kec. bogor selatan', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 45, 'kelurahan_id' => 20, 'kecamatan_id' => 2, 'alamat' => 'jl baru no 54 rt 05/10', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 46, 'kelurahan_id' => 32, 'kecamatan_id' => 2, 'alamat' => 'kantor kel rangga mekar jaya rt 1/09kel rangga mekar kec bogor selatan', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 47, 'kelurahan_id' => 21, 'kecamatan_id' => 2, 'alamat' => 'Jl. Cipaku NO.25 RT 001/ RW 001', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 48, 'kelurahan_id' => 27, 'kecamatan_id' => 2, 'alamat' => 'Kp. Hegar sari Rt.03/01', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 49, 'kelurahan_id' => 17, 'kecamatan_id' => 2, 'alamat' => 'Jl. Jaya Tunggal NO 17A RT001/003', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 50, 'kelurahan_id' => 19, 'kecamatan_id' => 2, 'alamat' => 'Komplek Kehutanan Bondongan Selatan No. 11 RT 002/ 007', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 51, 'kelurahan_id' => 24, 'kecamatan_id' => 2, 'alamat' => 'jl rulita no 85 rt 003/005 kel. haljasari kec. bogor selatan kota bogor', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 52, 'kelurahan_id' => 23, 'kecamatan_id' => 2, 'alamat' => 'Jl. Sukamanah NO 28', 'latitude' => null, 'longitude' => null],

            // Tanah Sareal (koperasi_id 53–68)
            ['koperasi_id' => 53, 'kelurahan_id' => 29, 'kecamatan_id' => 6, 'alamat' => 'sekretariat kantor kelurahan pakuan', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 54, 'kelurahan_id' => 62, 'kecamatan_id' => 6, 'alamat' => 'Jl. Singasari No. 1 Perumahan Cimanggu Permai Kedung jaya', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 55, 'kelurahan_id' => 60, 'kecamatan_id' => 6, 'alamat' => 'Jl. Nusa Indah No 3 RT 01/11', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 56, 'kelurahan_id' => 61, 'kecamatan_id' => 6, 'alamat' => 'Jl. Raya Cimanggu No. 4', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 57, 'kelurahan_id' => 66, 'kecamatan_id' => 6, 'alamat' => 'Jl. Ramin No.11 Rt.003/005, Perum Budi Agung', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 58, 'kelurahan_id' => 67, 'kecamatan_id' => 6, 'alamat' => 'Jl. H. Ahmad Yunus No. 04 RT.01/ RW 04', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 59, 'kelurahan_id' => 59, 'kecamatan_id' => 6, 'alamat' => 'Jl. Pool Bina Marga, Ds, Kayumanis', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 60, 'kelurahan_id' => 68, 'kecamatan_id' => 6, 'alamat' => 'Jl. RM. Tirto Adhi Soerjo Kel. Tanah Sareal Kec. Tanah Sareal Kota Bogor Jawa Barat', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 61, 'kelurahan_id' => 64, 'kecamatan_id' => 6, 'alamat' => "Jl. K.H Ahmad Sya' yani No 18 RT03 / RW14", 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 62, 'kelurahan_id' => 65, 'kecamatan_id' => 6, 'alamat' => 'Jl. Perum Taman Sari Perseda No. 1, Tanah Sereal, Kota Bogor 16166', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 63, 'kelurahan_id' => 58, 'kecamatan_id' => 6, 'alamat' => 'Jl. Cibadak', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 64, 'kelurahan_id' => 64, 'kecamatan_id' => 6, 'alamat' => 'Kel. Kencana Kec. Tanah Sareal, Kota Bogor, Jawa Barat', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 65, 'kelurahan_id' => 63, 'kecamatan_id' => 6, 'alamat' => 'Jl. Taman Cimanggu Utara No. 2', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 66, 'kelurahan_id' => 64, 'kecamatan_id' => 6, 'alamat' => 'Jl. Kedung Waringin', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 67, 'kelurahan_id' => 66, 'kecamatan_id' => 6, 'alamat' => 'Jl. Sukadamai', 'latitude' => null, 'longitude' => null],
            ['koperasi_id' => 68, 'kelurahan_id' => 67, 'kecamatan_id' => 6, 'alamat' => 'Jl. Sukaresmi', 'latitude' => null, 'longitude' => null],

];

        DB::table('lokasi')->insert($lokasi);
    }
}
