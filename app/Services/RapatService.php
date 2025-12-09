<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Services\LatestPerformaService;
class RapatService
{
    public function __construct(
        protected LatestPerformaService $performaService
    ) {}

    public function getAllRapat(): array
    {
        $latest = $this->performaService->latestPerKoperasi();

        // Ambil semua data rapat dari performa TERBARU
        $rows = DB::table('performa as p')
            ->joinSub($latest, 'lp', function ($join) {
                $join->on('p.koperasi_id', '=', 'lp.koperasi_id')
                     ->on('p.periode', '=', 'lp.max_periode');
            })
            ->join('performa_organisasi as po', 'po.performa_id', '=', 'p.id')
            ->leftJoin('rapat_koordinasi as r', 'r.performa_organisasi_id', '=', 'po.id')
            ->select([
                'r.rapat_pengurus',
                'r.rapat_pengawas',
                'r.rapat_gabungan',
                'r.rapat_pengurus_karyawan',
                'r.rapat_pengurus_anggota',
                'p.koperasi_id',
            ])
            ->get();

        // Template interval default
        $defaultFrekuensi = [
            'mingguan' => 0,
            'dua_mingguan' => 0,
            'bulanan' => 0,
            'dua_bulanan' => 0,
            'tiga_bulanan_lebih' => 0,
        ];

        // Mapper kolom → label output
        $map = [
            'rapat_pengurus' => 'Rapat Pengurus',
            'rapat_pengawas' => 'Rapat Pengawas',
            'rapat_gabungan' => 'Rapat Gabungan',
            'rapat_pengurus_karyawan' => 'Rapat Pengurus-Karyawan',
            'rapat_pengurus_anggota' => 'Rapat Pengurus-Anggota',
        ];

        $result = [];

        foreach ($map as $field => $label) {
            $frekuensi = $defaultFrekuensi;

            foreach ($rows as $row) {
                if (!$row->{$field}) continue;

                match ($row->{$field}) {
                    'satu_minggu'        => $frekuensi['mingguan']++,
                    'dua_minggu'         => $frekuensi['dua_mingguan']++,
                    'satu_bulan'         => $frekuensi['bulanan']++,
                    'dua_bulan'          => $frekuensi['dua_bulanan']++,
                    'tiga_bulan_lebih'   => $frekuensi['tiga_bulanan_lebih']++,
                };
            }

            $result[] = [
                'jenis_rapat' => $label,
                'frekuensi' => $frekuensi,
            ];
        }

        return $result;
    }
}
