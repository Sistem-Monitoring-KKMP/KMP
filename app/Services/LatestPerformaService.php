<?php
namespace App\Services;
use App\Models\Performa;
use Illuminate\Support\Facades\DB;

class LatestPerformaService
{
  public function latestPerKoperasi()
  {
    return DB::table('performa')
        ->selectRaw('koperasi_id, MAX(periode) as max_periode')
        ->groupBy('koperasi_id');
  }

  public function latestByKoperasi(int $koperasiId)
{
    return DB::table('performa')
        ->where('koperasi_id', $koperasiId)
        ->orderByDesc('periode')
        ->select('id', 'koperasi_id', 'periode')
        ->limit(1);
}


}
