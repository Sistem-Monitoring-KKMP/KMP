<?php

namespace App\Services;

use App\Models\Koperasi;
use App\Services\LatestPerformaService;
use App\Models\Performa;


class RankService {

   public function __construct(
      protected LatestPerformaService $performa
  ) {}

  public function rankCooperatives() {
  
    $latestPerforma = $this->performa->latestPerKoperasi();

    $rank = Koperasi::query()
      ->select('koperasi.id', 'koperasi.nama', 'p.cdi', 'p.bdi', 'p.odi')
      ->leftJoinSub($latestPerforma, 'lp', function ($join) {
          $join->on('lp.koperasi_id', '=', 'koperasi.id');
      })
      ->leftJoin('performa as p', function ($join) {
          $join->on('p.koperasi_id', '=', 'koperasi.id')
              ->on('p.periode', '=', 'lp.max_periode');
      })
      ->orderByDesc('p.cdi')
      ->limit(10)
      ->get();
      
    return $rank->toArray();
}
}
