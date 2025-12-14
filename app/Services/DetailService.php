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

    $latestPerforma = $this->latestPerformaService->latestByKoperasi($koperasiId)->first();

    $performaId = DB::table('performa')
    ->where('koperasi_id', $latestPerforma->koperasi_id)
    ->where('periode', $latestPerforma->periode)
    ->select('id', 'bdi', 'odi', 'cdi', 'kuadrant', 'periode')
    ->first();


    $organisasi = DB::table('performa_organisasi as po')
        ->where('po.performa_id', $performaId->id)
        ->first();

    $neraca      = $this->neracaService->getNeraca($koperasiId);
    $pertumbuhan = $this->keuanganService->getKeuangan($koperasiId);
    $unitUsaha   = $this->unitUsahaService->getUnitUsaha($koperasiId);
    $prinsip     = $this->prinsipService->GetPrinsipKoperasi($koperasiId);

    return [
        'id'             => $this->i($koperasi->id),
        'nama'           => $this->s($koperasi->nama),
        'kontak'         => $this->s($koperasi->kontak),
        'no_badan_hukum' => $this->s($koperasi->no_badan_hukum),
        'tahun'          => $this->i($koperasi->tahun),
        'status'         => $this->s($organisasi->status),
        'has_gm'         => $this->b($organisasi->general_manager),

        'lokasi' => [
            'alamat'    => $this->s($koperasi->alamat),
            'kecamatan' => $this->s($koperasi->kecamatan),
            'kelurahan' => $this->s($koperasi->kelurahan),
            'latitude'  => is_null($koperasi->latitude)  ? 0 : (float) $koperasi->latitude,
            'longitude' => is_null($koperasi->longitude) ? 0 : (float) $koperasi->longitude,
        ],

        'performa' => [
            'periode'  => $this->d($performaId->periode ?? null),
            'cdi'      => $this->f($performaId->cdi ?? null),
            'bdi'      => $this->f($performaId->bdi ?? null),
            'odi'      => $this->f($performaId->odi ?? null),
            'kuadrant' => $this->i($performaId->kuadrant ?? null),

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
                'neraca' => $neraca ?: [
                    'aktiva'  => [],
                    'passiva' => []
                ],
                'pertumbuhan' => [
                    'akumulasi' => $pertumbuhan ?: []
                ]
            ]
        ],

        'unit_usaha' => $unitUsaha ?: [],

        'prinsip_koperasi' => $prinsip ?: []
    ];
}

}