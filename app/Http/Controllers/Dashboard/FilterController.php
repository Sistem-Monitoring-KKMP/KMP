<?php 

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\DTO\FilterDTO;
use App\Models\Koperasi;

class FilterController extends Controller
{
  public function index(Request $request, SearchService $service)
  {
    $filter = FilterDTO::fromRequest($request);
    $filteredCooperatives = $service->filterCooperatives($filter);

    return Inertia::render('cooperatives/index', [
      'cooperatives' => $filteredCooperatives
    ]);
  }
}