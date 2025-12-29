<?php 

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\RankService;
use App\Services\LocationService;
use App\Services\AllPerformService;
use App\Services\HistoryPerformService;
use Inertia\Inertia;

class DashboardController extends Controller
{
  public function index(RankService $rank, LocationService $location, AllPerformService $perform, HistoryPerformService $history)
  {
    $rankTopData = $rank->rankUpCooperatives();
    $rankLowData = $rank->rankDownCooperatives();
    $locationData = $location->getAllLocations();
    $kpi = $perform->averagePerforma();
    $Tren = $history->TrenBulanan();

    return Inertia::render('dashboard', [
      'dashboardData'=> [
        'top_cdi' => $rankTopData,
        'low_cdi' => $rankLowData,
        'tren' => $Tren,
        'kpi' => $kpi
      ],
      'mapData' => $locationData
    ]);
  }
}