<?php

namespace App\Services;

use App\Models\Koperasi;
use App\Services\LatestPerformaService;
use App\Models\Performa;


class RankService {

   public function __construct(
      protected LatestPerformaService $performa
  ) {}

  public function rankUpCooperatives($limit = 10)
  {
    return $this->getCooperativeRankings('desc', $limit);
  }

  public function rankDownCooperatives($limit = 10)
  {
    return $this->getCooperativeRankings('asc', $limit);
  }

  
  private function getCooperativeRankings($direction = 'desc', $limit = 10)
  {
    $latestPerforma = $this->performa->latestPerKoperasi();

    $query = Koperasi::query()
      ->select('koperasi.id', 'koperasi.nama', 'p.cdi', 'p.bdi', 'p.odi')
      ->leftJoinSub($latestPerforma, 'lp', function ($join) {
          $join->on('lp.koperasi_id', '=', 'koperasi.id');
      })
      ->leftJoin('performa as p', function ($join) {
          $join->on('p.koperasi_id', '=', 'koperasi.id')
              ->on('p.periode', '=', 'lp.max_periode');
      });

    
    if ($direction === 'desc') {
        $query->orderByDesc('p.cdi');
    } else {
        $query->orderBy('p.cdi');
    }

    $rank = $query->limit($limit)->get();

    return $rank->toArray();
  }
}
