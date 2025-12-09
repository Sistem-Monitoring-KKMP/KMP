<?php
namespace App\Services;
use App\Services\LatestPerformaService;
use App\Models\Koperasi;

class LocationService
{
    public function __construct(
        protected LatestPerformaService $performaService
    ) {}

    public function getAllLocations(): array
    {
        $latestPerforma = $this->performaService->latestPerKoperasi();

        $locations = Koperasi::query()
            ->select([
                'koperasi.id',
                'koperasi.nama',
                'po.status',
                'p.cdi',
                'p.bdi',
                'p.odi',
                'l.latitude as lat',
                'l.longitude as lng',
                'l.alamat',
            ])

            // Lokasi
            ->leftJoin('lokasi as l', 'l.koperasi_id', '=', 'koperasi.id')
            ->whereNotNull('l.latitude')
            ->whereNotNull('l.longitude')

            ->leftJoinSub($latestPerforma, 'lp', function ($join) {
                $join->on('lp.koperasi_id', '=', 'koperasi.id');
            })

            ->leftJoin('performa as p', function ($join) {
                $join->on('p.koperasi_id', '=', 'koperasi.id')
                     ->on('p.periode', '=', 'lp.max_periode');
            })

            // Performa organisasi
            ->leftJoin('performa_organisasi as po', 'po.performa_id', '=', 'p.id')

            ->get();

        return $locations->toArray();
    }
}
