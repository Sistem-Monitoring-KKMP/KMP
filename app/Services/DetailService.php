<?php
namespace App\Services;
use App\Models\Koperasi;
use Illuminate\Support\Facades\DB;
use App\Services\PerformaService;
use App\Services\NeracaService;
use App\Services\LatestPerformaService;


class DetailService
{   
  private function i($value): int
{
    return is_null($value) ? 0 : (int) $value;
}

private function f($value): float
{
    return is_null($value) ? 0.0 : (float) $value;
}

private function s($value): string
{
    return is_null($value) || $value === '' ? '-' : (string) $value;
}

private function b($value): bool
{
    return (bool) ($value ?? false);
}

private function d($value): string
{
    return is_null($value) ? '-' : (string) $value;
}

  
  public function __construct(
        
        protected NeracaService $neracaService,
        protected KeuanganService $keuanganService,
        protected UnitUsahaService $unitUsahaService,
        protected PrinsipKoperasiService $prinsipService,
        protected LatestPerformaService $latestPerformaService
    ) {}
    public function getDetail(int $koperasiId): array
{
    $koperasi = Koperasi::query()
        ->leftJoin('lokasi as l', 'l.koperasi_id', '=', 'koperasi.id')
        ->leftJoin('kecamatan as kec', 'kec.id', '=', 'l.kecamatan_id')
        ->leftJoin('kelurahan as kel', 'kel.id', '=', 'l.kelurahan_id')
        ->where('koperasi.id', $koperasiId)
        ->select([
            'koperasi.id',
            'koperasi.nama',
            'koperasi.kontak',
            'koperasi.no_badan_hukum',
            'koperasi.tahun as tahun',

            'l.alamat',
            'kec.nama as kecamatan',
            'kel.nama as kelurahan',
            'l.latitude',
            'l.longitude',
        ])
        ->firstOrFail();

    // Get all performance records for the cooperative ordered by period descending
    $allPerforma = DB::table('performa')
        ->where('koperasi_id', $koperasiId)
        ->orderBy('periode', 'desc')
        ->select('id', 'bdi', 'odi', 'cdi', 'kuadrant', 'periode')
        ->get();

    $allNeraca   = $this->neracaService->getNeraca($koperasiId);
    $unitUsaha   = $this->unitUsahaService->getUnitUsaha($koperasiId);
    $prinsip     = $this->prinsipService->GetPrinsipKoperasi($koperasiId);

    // Get all financial data for the cooperative
    $allKeuangan = $this->keuanganService->getKeuangan($koperasiId);

    // Get the latest organizational data
    $latestOrganisasi = null;
    if ($allPerforma->count() > 0) {
        $latestPerforma = $allPerforma->first();
        $latestOrganisasi = DB::table('performa_organisasi as po')
            ->where('po.performa_id', $latestPerforma->id)
            ->first();
    }

    return [
        'id'             => $this->i($koperasi->id),
        'nama'           => $this->s($koperasi->nama),
        'kontak'         => $this->s($koperasi->kontak),
        'no_badan_hukum' => $this->s($koperasi->no_badan_hukum),
        'tahun'          => $this->i($koperasi->tahun),
        'status'         => $this->s($latestOrganisasi->status ?? '-'),
        'has_gm'         => $this->b($latestOrganisasi->general_manager ?? false),

        'lokasi' => [
            'alamat'    => $this->s($koperasi->alamat),
            'kecamatan' => $this->s($koperasi->kecamatan),
            'kelurahan' => $this->s($koperasi->kelurahan),
            'latitude'  => is_null($koperasi->latitude)  ? 0 : (float) $koperasi->latitude,
            'longitude' => is_null($koperasi->longitude) ? 0 : (float) $koperasi->longitude,
        ],

        'performa' => $allPerforma->map(function ($item) use ($koperasiId, $allNeraca, $allKeuangan) {
            $organisasi = DB::table('performa_organisasi as po')
                ->where('po.performa_id', $item->id)
                ->first();

            // Find the financial data that corresponds to this specific performance period
            $periodSpecificKeuangan = collect($allKeuangan)->first(function ($keu) use ($item) {
                return $keu['tanggal'] == $item->periode;
            });

            // Find the neraca data that corresponds to this specific performance period
            $periodSpecificNeraca = collect($allNeraca)->first(function ($n) use ($item) {
                return $n['periode'] == $item->periode;
            });

            return [
                'periode'  => $this->d($item->periode),
                'cdi'      => $this->f($item->cdi),
                'bdi'      => $this->f($item->bdi),
                'odi'      => $this->f($item->odi),
                'kuadrant' => $this->i($item->kuadrant),

                'organisasi' => [
                    'jumlah_pengurus' => $this->i($organisasi->jumlah_pengurus ?? null),
                    'jumlah_pengawas' => $this->i($organisasi->jumlah_pengawas ?? null),
                    'jumlah_karyawan' => $this->i($organisasi->jumlah_karyawan ?? null),

                    'anggota' => [
                        'total'       => $this->i($organisasi->total_anggota ?? null),
                        'aktif'       => $this->i($organisasi->anggota_aktif ?? null),
                        'tidak_aktif' => max(
                            0,
                            $this->i($organisasi->total_anggota ?? null) -
                            $this->i($organisasi->anggota_aktif ?? null)
                        ),
                    ]
                ],

                'bisnis' => [
                    'neraca' => $periodSpecificNeraca ?: [],
                    'pertumbuhan' => $periodSpecificKeuangan ?: []
                ]
            ];
        })->toArray(),

        'unit_usaha' => $unitUsaha ?: [],

        'prinsip_koperasi' => $prinsip ?: []
    ];
}

}