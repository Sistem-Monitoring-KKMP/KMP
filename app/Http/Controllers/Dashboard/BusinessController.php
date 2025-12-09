<?php 

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\HistoryPerformService;
use App\Services\KeuanganService;
use App\Services\NeracaService;
use Inertia\Inertia;

class BusinessController extends Controller
{
  public function index(KeuanganService $financial, NeracaService $neraca, HistoryPerformService $Bdi)
  {
    $historyData = $financial->getAllKeuangan();
    $neraca = $neraca->getAllNeraca();
    $bdi = $Bdi->getAllBdi();
    $latest = !empty($historyData) ? end($historyData) : null;

    dd($latest);
    
    return Inertia::render('business/index', [
      'ringkasan_finansial' => $latest,
      'neraca' => $neraca,
      'bdi_trend' => $bdi,
      'pertumbuhan_financial' => $historyData,
    ]);
  }
}