<?php
  namespace App\Services;
  use App\Services\LatestPerformaService;
  use Illuminate\Support\Facades\DB;

  class PrinsipKoperasiService
  {
    public function __construct(
        protected LatestPerformaService $performaService
    ) {}
    public function getAllPrinsipKoperasi(): array
{
    $latest = $this->performaService->latestPerKoperasi();

    $result = DB::table('performa as p')
        ->joinSub($latest, 'lp', function ($join) {
            $join->on('p.koperasi_id', '=', 'lp.koperasi_id')
                 ->on('p.periode', '=', 'lp.max_periode');
        })
        ->join('performa_organisasi as po', 'po.performa_id', '=', 'p.id')
        ->join('prinsip_koperasi as pk', 'pk.performa_organisasi_id', '=', 'po.id')
        ->selectRaw('
            ROUND(AVG(pk.sukarela_terbuka), 2) as avg_sukarela_terbuka,
            ROUND(AVG(pk.demokratis), 2)       as avg_demokratis,
            ROUND(AVG(pk.ekonomi), 2)         as avg_ekonomi,
            ROUND(AVG(pk.kemandirian), 2)     as avg_kemandirian,
            ROUND(AVG(pk.pendidikan), 2)      as avg_pendidikan,
            ROUND(AVG(pk.kerja_sama), 2)      as avg_kerja_sama,
            ROUND(AVG(pk.kepedulian), 2)      as avg_kepedulian
        ')
        ->first();

    
    return [
        [
            'prinsip' => 'Keanggotaan Sukarela',
            'skor' => (float) ($result->avg_sukarela_terbuka ?? 0),
        ],
        [
            'prinsip' => 'Pengendalian Demokratis',
            'skor' => (float) ($result->avg_demokratis ?? 0),
        ],
        [
            'prinsip' => 'Partisipasi Ekonomi',
            'skor' => (float) ($result->avg_ekonomi ?? 0),
        ],
        [
            'prinsip' => 'Otonomi',
            'skor' => (float) ($result->avg_kemandirian ?? 0),
        ],
        [
            'prinsip' => 'Pendidikan',
            'skor' => (float) ($result->avg_pendidikan ?? 0),
        ],
        [
            'prinsip' => 'Kerjasama',
            'skor' => (float) ($result->avg_kerja_sama ?? 0),
        ],
        [
            'prinsip' => 'Kepedulian Komunitas',
            'skor' => (float) ($result->avg_kepedulian ?? 0),
        ],
    ];
}


    public function GetPrinsipKoperasi(int $koperasiId): array
{
    $latest = $this->performaService->latestPerKoperasi();

    $result = DB::table('performa as p')
        ->joinSub($latest, 'lp', function ($join) {
            $join->on('p.koperasi_id', '=', 'lp.koperasi_id')
                 ->on('p.periode', '=', 'lp.max_periode');
        })

        ->join('performa_organisasi as po', 'po.performa_id', '=', 'p.id')
        ->join('prinsip_koperasi as pk', 'pk.performa_organisasi_id', '=', 'po.id')

        
        ->where('p.koperasi_id', $koperasiId)

        ->selectRaw('
            pk.sukarela_terbuka,
            pk.demokratis,
            pk.ekonomi,
            pk.kemandirian,
            pk.pendidikan,
            pk.kerja_sama,
            pk.kepedulian
        ')
        ->first();

    return [
        'koperasi_id'      => $koperasiId,
        'sukarela_terbuka' => (int) ($result->sukarela_terbuka ?? 0),
        'demokratis'       => (int) ($result->demokratis ?? 0),
        'ekonomi'          => (int) ($result->ekonomi ?? 0),
        'kemandirian'      => (int) ($result->kemandirian ?? 0),
        'pendidikan'       => (int) ($result->pendidikan ?? 0),
        'kerja_sama'       => (int) ($result->kerja_sama ?? 0),
        'kepedulian'       => (int) ($result->kepedulian ?? 0),
    ];
}
  }