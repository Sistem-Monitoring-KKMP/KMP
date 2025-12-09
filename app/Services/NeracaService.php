<?php

namespace App\Services;

use App\Services\LatestPerformaService;
use Illuminate\Support\Facades\DB;

class NeracaService
{
    public function __construct(
        
        protected LatestPerformaService $latestPerformaService
    ) {}

    public function getAllNeraca(): array
    {
        // Ambil performa bisnis TERBARU per koperasi
        $max = $this->latestPerformaService->latestPerKoperasi();

        $latest = DB::table('performa as lp')
            ->joinSub($max, 'm', function ($join) {
                $join->on('lp.koperasi_id', '=', 'm.koperasi_id')
                    ->on('lp.periode', '=', 'm.max_periode');
            })
    ->select('lp.id', 'lp.koperasi_id', 'lp.periode');

        $result = DB::table('performa_bisnis as pb')
            ->joinSub($latest, 'lp', function ($join) {
                $join->on('pb.performa_id', '=', 'lp.id');
                    
            })

            ->leftJoin('neraca_aktiva as na', 'na.performa_bisnis_id', '=', 'pb.id')
            ->leftJoin('neraca_passiva as np', 'np.performa_bisnis_id', '=', 'pb.id')

            ->selectRaw('
                ROUND(AVG(na.kas), 0) as avg_kas,
                ROUND(AVG(na.piutang), 0) as avg_piutang,
                ROUND(AVG(na.aktiva_lancar), 0) as avg_aktiva_lancar,

                ROUND(AVG(na.tanah), 0) as avg_tanah,
                ROUND(AVG(na.bangunan), 0) as avg_bangunan,
                ROUND(AVG(na.kendaraan), 0) as avg_kendaraan,
                ROUND(AVG(na.aktiva_tetap), 0) as avg_aktiva_tetap,

                ROUND(AVG(na.total_aktiva), 0) as avg_total_aktiva,

                ROUND(AVG(np.hutang_lancar), 0) as avg_hutang_lancar,
                ROUND(AVG(np.hutang_jangka_panjang), 0) as avg_hutang_jangka_panjang,
                ROUND(AVG(np.modal), 0) as avg_modal,
                ROUND(AVG(np.total_passiva), 0) as avg_total_passiva
            ')
            ->first();

        return [
            'aktiva' => [
                'aktiva_lancar' => [
                    'kas'     => (int) ($result->avg_kas ?? 0),
                    'piutang' => (int) ($result->avg_piutang ?? 0),
                    'total'   => (int) ($result->avg_aktiva_lancar ?? 0),
                ],
                'aktiva_tetap' => [
                    'tanah'     => (int) ($result->avg_tanah ?? 0),
                    'bangunan'  => (int) ($result->avg_bangunan ?? 0),
                    'kendaraan' => (int) ($result->avg_kendaraan ?? 0),
                    'total'     => (int) ($result->avg_aktiva_tetap ?? 0),
                ],
                'total_aktiva' => (int) ($result->avg_total_aktiva ?? 0),
            ],
            'passiva' => [
                'hutang_lancar'         => (int) ($result->avg_hutang_lancar ?? 0),
                'hutang_jangka_panjang'=> (int) ($result->avg_hutang_jangka_panjang ?? 0),
                'modal'                 => (int) ($result->avg_modal ?? 0),
                'total_passiva'         => (int) ($result->avg_total_passiva ?? 0),
            ],
        ];
    }

    public function getNeraca(int $koperasiId): array
{
    // Ambil performa TERBARU untuk koperasi tertentu
    $latest = $this->latestPerformaService->latestByKoperasi($koperasiId);

    $result = DB::table('performa_bisnis as pb')
        ->joinSub($latest, 'lp', function ($join) {
            $join->on('pb.performa_id', '=', 'lp.id');
                 
        })

        ->leftJoin('neraca_aktiva as na', 'na.performa_bisnis_id', '=', 'pb.id')
        ->leftJoin('neraca_passiva as np', 'np.performa_bisnis_id', '=', 'pb.id')

        ->selectRaw('
            na.kas,
            na.piutang,
            na.aktiva_lancar,

            na.tanah,
            na.bangunan,
            na.kendaraan,
            na.aktiva_tetap,
            na.total_aktiva,

            np.hutang_lancar,
            np.hutang_jangka_panjang,
            np.modal,
            np.total_passiva
        ')
        ->first();

    if (! $result) {
        return [
            'aktiva' => [],
            'passiva' => []
        ];
    }

    return [
        'aktiva' => [
            'aktiva_lancar' => [
                'kas'     => (int) $result->kas,
                'piutang' => (int) $result->piutang,
                'total'   => (int) $result->aktiva_lancar,
            ],
            'aktiva_tetap' => [
                'tanah'     => (int) $result->tanah,
                'bangunan'  => (int) $result->bangunan,
                'kendaraan' => (int) $result->kendaraan,
                'total'     => (int) $result->aktiva_tetap,
            ],
            'total_aktiva' => (int) $result->total_aktiva,
        ],
        'passiva' => [
            'hutang_lancar'          => (int) $result->hutang_lancar,
            'hutang_jangka_panjang' => (int) $result->hutang_jangka_panjang,
            'modal'                 => (int) $result->modal,
            'total_passiva'         => (int) $result->total_passiva,
        ],
    ];
}

}