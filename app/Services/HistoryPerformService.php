<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;

class HistoryPerformService
{
    public function TrenBulanan(): array
    {
        $rows = DB::table('performa')
            ->selectRaw("
                DATE(periode) as tanggal,
                ROUND(AVG(cdi), 2) as avg_cdi,
                ROUND(AVG(bdi), 2) as avg_bdi,
                ROUND(AVG(odi), 2) as avg_odi
            ")
            ->groupBy(DB::raw("DATE(periode)"))
            ->orderBy('tanggal', 'asc')
            ->get();

        return $rows->map(fn ($row) => [
            'tanggal'   => $row->tanggal,
            'cdi' => round((float) $row->avg_cdi, 2),
            'bdi' => round((float) $row->avg_bdi, 2),
            'odi' => round((float) $row->avg_odi, 2),
        ])->toArray();
    }

    public function getAllBdi(): array
    {
        return DB::table('performa')
            ->selectRaw('
                DATE(periode) as periode,
                ROUND(AVG(bdi), 2) as avg_bdi
            ')
            ->whereNotNull('bdi')
            ->groupBy(DB::raw('DATE(periode)'))
            ->orderBy(DB::raw('DATE(periode)'), 'asc')
            ->get()
            ->map(fn ($row) => [
                'periode' => $row->periode,
                'avg_bdi' => (float) $row->avg_bdi,
            ])
            ->toArray();
    }
}
