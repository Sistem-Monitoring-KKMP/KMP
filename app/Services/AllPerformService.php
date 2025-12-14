<?php

namespace App\Services;
use App\Services\LatestPerformaService as PerformaService;
use Illuminate\Support\Facades\DB;

class AllPerformService
{
    public function __construct(
        protected PerformaService $performaService
    ) {}

    public function averagePerforma(): array
    {
        $latest = $this->performaService->latestPerKoperasi();

        $result = DB::table('performa as p')
            ->joinSub($latest, 'lp', function ($join) {
                $join->on('p.koperasi_id', '=', 'lp.koperasi_id')
                     ->on('p.periode', '=', 'lp.max_periode');
            })
            ->selectRaw('
                AVG(p.cdi) as avg_cdi,
                AVG(p.bdi) as avg_bdi,
                AVG(p.odi) as avg_odi,
                COUNT(DISTINCT p.koperasi_id) as total_koperasi
            ')
            ->first();

        return [
            'cdi' => round((float) $result->avg_cdi, 2),
            'bdi' => round((float) $result->avg_bdi, 2),
            'odi' => round((float) $result->avg_odi, 2),
            'total_koperasi' => (int) $result->total_koperasi,
        ];
    }
}
