<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Services\LatestPerformaService;

class PelatihanService
{
    public function __construct(
        protected LatestPerformaService $performaService
    ) {}

    public function getAllPelatihan(): array
    {
        $latestPerforma = $this->performaService->latestPerKoperasi();

        return DB::table('performa as p')
            ->joinSub($latestPerforma, 'lp', function ($join) {
                $join->on('p.koperasi_id', '=', 'lp.koperasi_id')
                     ->on('p.periode', '=', 'lp.max_periode');
            })

            ->join('performa_organisasi as po', 'po.performa_id', '=', 'p.id')
            ->join('pelatihan as pel', 'pel.performa_organisasi_id', '=', 'po.id')

            ->selectRaw('
                pel.pelatihan as sasaran,
                COUNT(DISTINCT p.koperasi_id) as jumlah_terlaksana,
                SUM(pel.akumulasi) as total_sesi
            ')
            ->groupBy('pel.pelatihan')
            ->orderBy('pel.pelatihan')
            ->get()
            ->map(fn ($row) => [
                'sasaran' => $row->sasaran,
                'jumlah_terlaksana' => (int) $row->jumlah_terlaksana,
                'total_sesi' => (int) ($row->total_sesi ?? 0),
            ])
            ->toArray();
    }
    
}
