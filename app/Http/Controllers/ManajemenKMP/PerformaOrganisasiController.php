<?php
// filepath: c:\Users\mrizk\Desktop\Code\KMP\KMP-Backend\app\Http\Controllers\ManajemenKMP\PerformaOrganisasiController.php

namespace App\Http\Controllers\ManajemenKMP;

use App\Http\Controllers\Controller;
use App\Models\PerformaOrganisasi;
use App\Models\Performa;
use App\Models\RencanaStrategis;
use App\Models\PrinsipKoperasi;
use App\Models\Pelatihan;
use App\Models\RapatKoordinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PerformaOrganisasiController extends Controller
{
    /**
     * Get Performa Organisasi by Performa ID
     */
    public function show($koperasiId, $performaId)
    {
        try {
            $performa = Performa::where('koperasi_id', $koperasiId)
                ->where('id', $performaId)
                ->firstOrFail();

            $performaOrganisasi = PerformaOrganisasi::where('performa_id', $performaId)
                ->with([
                    'rencanaStrategis',
                    'prinsipKoperasi',
                    'pelatihan',
                    'rapatKoordinasi'
                ])
                ->first();

            if (!$performaOrganisasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Performa Organisasi not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Get Performa Organisasi successfully',
                'data' => $performaOrganisasi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get Performa Organisasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save/Update Performa Organisasi
     */
    public function save(Request $request, $koperasiId, $performaId)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_pengurus' => 'nullable|integer',
            'jumlah_pengawas' => 'nullable|integer',
            'jumlah_karyawan' => 'nullable|integer',
            'status' => 'nullable|in:Aktif,TidakAktif,Pembentukan',
            'total_anggota' => 'nullable|integer',
            'anggota_aktif' => 'nullable|integer',
            'anggota_tidak_aktif' => 'nullable|integer',
            'general_manager' => 'boolean',
            'rapat_tepat_waktu' => 'boolean',
            'rapat_luar_biasa' => 'boolean',
            'pergantian_pengurus' => 'boolean',
            'pergantian_pengawas' => 'boolean',

            // Rencana Strategis
            'rencana_strategis.visi' => 'boolean',
            'rencana_strategis.misi' => 'boolean',
            'rencana_strategis.rencana_strategis' => 'boolean',
            'rencana_strategis.sasaran_operasional' => 'boolean',
            'rencana_strategis.art' => 'boolean',

            // Prinsip Koperasi
            'prinsip_koperasi.sukarela_terbuka' => 'nullable|integer|between:1,5',
            'prinsip_koperasi.demokratis' => 'nullable|integer|between:1,5',
            'prinsip_koperasi.ekonomi' => 'nullable|integer|between:1,5',
            'prinsip_koperasi.kemandirian' => 'nullable|integer|between:1,5',
            'prinsip_koperasi.pendidikan' => 'nullable|integer|between:1,5',
            'prinsip_koperasi.kerja_sama' => 'nullable|integer|between:1,5',
            'prinsip_koperasi.kepedulian' => 'nullable|integer|between:1,5',

            // Pelatihan (array)
            'pelatihan' => 'array',
            'pelatihan.*.pelatihan' => 'required|in:Pengurus,Pengawas,GeneralManager,Karyawan,Anggota,NonAnggota',
            'pelatihan.*.akumulasi' => 'nullable|integer',

            // Rapat Koordinasi
            'rapat_koordinasi.rapat_pengurus' => 'nullable|in:satu_minggu,dua_minggu,satu_bulan,dua_bulan,tiga_bulan_lebih',
            'rapat_koordinasi.rapat_pengawas' => 'nullable|in:satu_minggu,dua_minggu,satu_bulan,dua_bulan,tiga_bulan_lebih',
            'rapat_koordinasi.rapat_gabungan' => 'nullable|in:satu_minggu,dua_minggu,satu_bulan,dua_bulan,tiga_bulan_lebih',
            'rapat_koordinasi.rapat_pengurus_karyawan' => 'nullable|in:satu_minggu,dua_minggu,satu_bulan,dua_bulan,tiga_bulan_lebih',
            'rapat_koordinasi.rapat_pengurus_anggota' => 'nullable|in:satu_minggu,dua_minggu,satu_bulan,dua_bulan,tiga_bulan_lebih',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Verify performa exists
            $performa = Performa::where('koperasi_id', $koperasiId)
                ->where('id', $performaId)
                ->firstOrFail();

            // Get or create PerformaOrganisasi
            $performaOrganisasi = PerformaOrganisasi::firstOrCreate(
                ['performa_id' => $performaId],
                ['responden_id' => $performa->koperasi->responden_id ?? null]
            );

            // Update basic fields
            $performaOrganisasi->update([
                'jumlah_pengurus' => $request->input('jumlah_pengurus'),
                'jumlah_pengawas' => $request->input('jumlah_pengawas'),
                'jumlah_karyawan' => $request->input('jumlah_karyawan'),
                'status' => $request->input('status'),
                'total_anggota' => $request->input('total_anggota'),
                'anggota_aktif' => $request->input('anggota_aktif'),
                'anggota_tidak_aktif' => $request->input('anggota_tidak_aktif'),
                'general_manager' => $request->input('general_manager', false),
                'rapat_tepat_waktu' => $request->input('rapat_tepat_waktu', false),
                'rapat_luar_biasa' => $request->input('rapat_luar_biasa', false),
                'pergantian_pengurus' => $request->input('pergantian_pengurus', false),
                'pergantian_pengawas' => $request->input('pergantian_pengawas', false),
            ]);

            // Save Rencana Strategis
            if ($request->has('rencana_strategis')) {
                RencanaStrategis::updateOrCreate(
                    ['performa_organisasi_id' => $performaOrganisasi->id],
                    [
                        'visi' => $request->input('rencana_strategis.visi', false),
                        'misi' => $request->input('rencana_strategis.misi', false),
                        'rencana_strategis' => $request->input('rencana_strategis.rencana_strategis', false),
                        'sasaran_operasional' => $request->input('rencana_strategis.sasaran_operasional', false),
                        'art' => $request->input('rencana_strategis.art', false),
                    ]
                );
            }

            // Save Prinsip Koperasi
            if ($request->has('prinsip_koperasi')) {
                PrinsipKoperasi::updateOrCreate(
                    ['performa_organisasi_id' => $performaOrganisasi->id],
                    $request->prinsip_koperasi
                );
            }

            // Save Pelatihan
            if ($request->has('pelatihan')) {
                // Delete existing
                Pelatihan::where('performa_organisasi_id', $performaOrganisasi->id)->delete();

                // Create new
                foreach ($request->pelatihan as $pelatihanItem) {
                    Pelatihan::create([
                        'performa_organisasi_id' => $performaOrganisasi->id,
                        'pelatihan' => $pelatihanItem['pelatihan'],
                        'akumulasi' => $pelatihanItem['akumulasi'] ?? null,
                    ]);
                }
            }

            // Save Rapat Koordinasi
            if ($request->has('rapat_koordinasi')) {
                RapatKoordinasi::updateOrCreate(
                    ['performa_organisasi_id' => $performaOrganisasi->id],
                    $request->rapat_koordinasi
                );
            }

            DB::commit();

            // Load relationships
            $performaOrganisasi->load([
                'rencanaStrategis',
                'prinsipKoperasi',
                'pelatihan',
                'rapatKoordinasi'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Performa Organisasi saved successfully',
                'data' => $performaOrganisasi
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save Performa Organisasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
