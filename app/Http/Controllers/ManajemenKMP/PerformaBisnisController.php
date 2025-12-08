<?php
// filepath: c:\Users\mrizk\Desktop\Code\KMP\KMP-Backend\app\Http\Controllers\ManajemenKMP\PerformaBisnisController.php

namespace App\Http\Controllers\ManajemenKMP;

use App\Http\Controllers\Controller;
use App\Models\PerformaBisnis;
use App\Models\Performa;
use App\Models\HubunganLembaga;
use App\Models\UnitUsaha;
use App\Models\Keuangan;
use App\Models\NeracaAktiva;
use App\Models\NeracaPassiva;
use App\Models\MasalahKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PerformaBisnisController extends Controller
{
    /**
     * Get Performa Bisnis by Performa ID
     */
    public function show($koperasiId, $performaId)
    {
        try {
            $performa = Performa::where('koperasi_id', $koperasiId)
                ->where('id', $performaId)
                ->firstOrFail();

            $performaBisnis = PerformaBisnis::where('performa_id', $performaId)
                ->with([
                    'hubunganLembaga',
                    'unitUsaha',
                    'keuangan',
                    'neracaAktiva',
                    'neracaPassiva',
                    'masalahKeuangan'
                ])
                ->first();

            if (!$performaBisnis) {
                return response()->json([
                    'success' => false,
                    'message' => 'Performa Bisnis not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Get Performa Bisnis successfully',
                'data' => $performaBisnis
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get Performa Bisnis',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save/Update Performa Bisnis
     */
    public function save(Request $request, $koperasiId, $performaId)
    {
        $validator = Validator::make($request->all(), [
            'proyeksi_rugi_laba' => 'boolean',
            'proyeksi_arus_kas' => 'boolean',

            // Hubungan Lembaga (array)
            'hubungan_lembaga' => 'array',
            'hubungan_lembaga.*.lembaga' => 'required|in:Perbankan Pemerintah,Perbankan Swasta,keuangan Non-Bank,BUMN,Daerah,Swasta,Masyarakat',
            'hubungan_lembaga.*.kemudahan' => 'nullable|integer|between:1,4',
            'hubungan_lembaga.*.intensitas' => 'nullable|integer|between:1,4',
            'hubungan_lembaga.*.dampak' => 'nullable|integer|between:1,4',

            // Unit Usaha (array)
            'unit_usaha' => 'array',
            'unit_usaha.*.unit' => 'required|in:Gerai Sembako,Klinik Desa,Gerai Obat,Jasa Logistik,Gudang,Simpan Pinjam,Unit Lain',
            'unit_usaha.*.volume_usaha' => 'nullable|integer',
            'unit_usaha.*.investasi' => 'nullable|integer',
            'unit_usaha.*.model_kerja' => 'nullable|integer',
            'unit_usaha.*.surplus' => 'nullable|integer',
            'unit_usaha.*.jumlah_sdm' => 'nullable|integer',
            'unit_usaha.*.jumlah_anggota' => 'nullable|integer',

            // Keuangan
            'keuangan.pinjaman_bank' => 'nullable|integer',
            'keuangan.investasi' => 'nullable|integer',
            'keuangan.modal_kerja' => 'nullable|integer',
            'keuangan.simpanan_anggota' => 'nullable|integer',
            'keuangan.hibah' => 'nullable|integer',
            'keuangan.omset' => 'nullable|integer',
            'keuangan.operasional' => 'nullable|integer',
            'keuangan.surplus' => 'nullable|integer',

            // Neraca Aktiva
            'neraca_aktiva.kas' => 'nullable|integer',
            'neraca_aktiva.piutang' => 'nullable|integer',
            'neraca_aktiva.aktiva_lancar' => 'nullable|integer',
            'neraca_aktiva.tanah' => 'nullable|integer',
            'neraca_aktiva.bangunan' => 'nullable|integer',
            'neraca_aktiva.kendaraan' => 'nullable|integer',
            'neraca_aktiva.aktiva_tetap' => 'nullable|integer',
            'neraca_aktiva.total_aktiva' => 'nullable|integer',

            // Neraca Passiva
            'neraca_passiva.hutang_lancar' => 'nullable|integer',
            'neraca_passiva.hutang_jangka_panjang' => 'nullable|integer',
            'neraca_passiva.total_hutang' => 'nullable|integer',
            'neraca_passiva.modal' => 'nullable|integer',
            'neraca_passiva.total_passiva' => 'nullable|integer',

            // Masalah Keuangan
            'masalah_keuangan.rugi_keseluruhan' => 'boolean',
            'masalah_keuangan.rugi_sebagian' => 'boolean',
            'masalah_keuangan.arus_kas' => 'boolean',
            'masalah_keuangan.piutang' => 'boolean',
            'masalah_keuangan.jatuh_tempo' => 'boolean',
            'masalah_keuangan.kredit' => 'boolean',
            'masalah_keuangan.penggelapan' => 'boolean',
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

            // Get or create PerformaBisnis
            $performaBisnis = PerformaBisnis::firstOrCreate(
                ['performa_id' => $performaId],
                ['responden_id' => $performa->koperasi->responden_id ?? null]
            );

            // Update basic fields
            $performaBisnis->update([
                'proyeksi_rugi_laba' => $request->input('proyeksi_rugi_laba', false),
                'proyeksi_arus_kas' => $request->input('proyeksi_arus_kas', false),
            ]);

            // Save Hubungan Lembaga
            if ($request->has('hubungan_lembaga')) {
                // Delete existing
                HubunganLembaga::where('performa_bisnis_id', $performaBisnis->id)->delete();

                // Create new
                foreach ($request->hubungan_lembaga as $lembaga) {
                    HubunganLembaga::create([
                        'performa_bisnis_id' => $performaBisnis->id,
                        'lembaga' => $lembaga['lembaga'],
                        'kemudahan' => $lembaga['kemudahan'] ?? null,
                        'intensitas' => $lembaga['intensitas'] ?? null,
                        'dampak' => $lembaga['dampak'] ?? null,
                    ]);
                }
            }

            // Save Unit Usaha
            if ($request->has('unit_usaha')) {
                // Delete existing
                UnitUsaha::where('performa_bisnis_id', $performaBisnis->id)->delete();

                // Create new
                foreach ($request->unit_usaha as $unit) {
                    UnitUsaha::create([
                        'performa_bisnis_id' => $performaBisnis->id,
                        'unit' => $unit['unit'],
                        'volume_usaha' => $unit['volume_usaha'] ?? null,
                        'investasi' => $unit['investasi'] ?? null,
                        'model_kerja' => $unit['model_kerja'] ?? null,
                        'surplus' => $unit['surplus'] ?? null,
                        'jumlah_sdm' => $unit['jumlah_sdm'] ?? null,
                        'jumlah_anggota' => $unit['jumlah_anggota'] ?? null,
                    ]);
                }
            }

            // Save Keuangan
            if ($request->has('keuangan')) {
                Keuangan::updateOrCreate(
                    ['performa_bisnis_id' => $performaBisnis->id],
                    $request->keuangan
                );
            }

            // Save Neraca Aktiva
            if ($request->has('neraca_aktiva')) {
                NeracaAktiva::updateOrCreate(
                    ['performa_bisnis_id' => $performaBisnis->id],
                    $request->neraca_aktiva
                );
            }

            // Save Neraca Passiva
            if ($request->has('neraca_passiva')) {
                NeracaPassiva::updateOrCreate(
                    ['performa_bisnis_id' => $performaBisnis->id],
                    $request->neraca_passiva
                );
            }

            // Save Masalah Keuangan
            if ($request->has('masalah_keuangan')) {
                MasalahKeuangan::updateOrCreate(
                    ['performa_bisnis_id' => $performaBisnis->id],
                    $request->masalah_keuangan
                );
            }

            DB::commit();

            // Load relationships
            $performaBisnis->load([
                'hubunganLembaga',
                'unitUsaha',
                'keuangan',
                'neracaAktiva',
                'neracaPassiva',
                'masalahKeuangan'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Performa Bisnis saved successfully',
                'data' => $performaBisnis
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save Performa Bisnis',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
