<?php 

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\PrinsipKoperasiService;
use App\Services\PelatihanService;
use App\Services\RapatService;
use Inertia\Inertia;

class OrganizationController extends Controller
{
  public function index(PrinsipKoperasiService $prinsip, PelatihanService $pelatihan, RapatService $rapat)
  {
    $prinsip = $prinsip->getAllPrinsipKoperasi();
    $pelatihan = $pelatihan->getAllPelatihan();
    $rapat = $rapat->getAllRapat();

    return Inertia::render('organization/index', [
      'organizationData' => [
        'prinsip_koperasi' => $prinsip,
        'pelatihan' => $pelatihan,
        'rapat' => $rapat,
      ],
    ]);

  }
}