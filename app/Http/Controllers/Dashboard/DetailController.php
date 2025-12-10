<?php 

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\DetailService;
use Inertia\Inertia;

class DetailController extends Controller
{
  public function index(int $koperasiId, DetailService $detailService)
  {
    $detail = $detailService->getDetail($koperasiId);
    // dd($detail);

    return Inertia::render('cooperatives/show', [
    'data' => [$detail]
    ]);

    
    
  }
}