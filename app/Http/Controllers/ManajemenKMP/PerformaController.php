<?php

namespace App\Http\Controllers\ManajemenKMP;

use App\Http\Controllers\Controller;
use App\Models\Performa;
use App\Models\PerformaBisnis;
use App\Models\PerformaOrganisasi;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PerformaController extends Controller
{
    /**
     * Get all performa periods for a koperasi
     */
    public function getPeriods($koperasiId)
    {
        try {
            $periods = Performa::where('koperasi_id', $koperasiId)
                ->orderBy('periode', 'desc')
                ->get(['id', 'periode', 'cdi', 'bdi', 'odi', 'kuadrant'])
                ->map(function ($performa) {
                    return [
                        'id' => $performa->id,
                        'periode' => $performa->periode,
                        'year' => date('Y', strtotime($performa->periode)),
                        'month' => date('m', strtotime($performa->periode)),
                        'month_year' => date('Y-m', strtotime($performa->periode)),
                        'formatted' => date('F Y', strtotime($performa->periode)),
                        'cdi' => $performa->cdi,
                        'bdi' => $performa->bdi,
                        'odi' => $performa->odi,
                        'kuadrant' => $performa->kuadrant,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Get periods successfully',
                'data' => $periods
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get periods',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get performa by koperasi and period (YYYY-MM format)
     */
    public function getByPeriod($koperasiId, $period)
    {
        try {
            // Period format: YYYY-MM
            $performa = Performa::where('koperasi_id', $koperasiId)
                ->whereYear('periode', substr($period, 0, 4))
                ->whereMonth('periode', substr($period, 5, 2))
                ->with([
                    'performaBisnis.hubunganLembaga',
                    'performaBisnis.unitUsaha',
                    'performaBisnis.keuangan',
                    'performaBisnis.neracaAktiva',
                    'performaBisnis.neracaPassiva',
                    'performaBisnis.masalahKeuangan',
                    'performaOrganisasi.rencanaStrategis',
                    'performaOrganisasi.prinsipKoperasi',
                    'performaOrganisasi.pelatihan',
                    'performaOrganisasi.rapatKoordinasi'
                ])
                ->first();

            if (!$performa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Performa not found for this period'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Get performa successfully',
                'data' => $performa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get performa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create or update performa
     */
    public function savePerforma(Request $request, $koperasiId)
    {
        $validator = Validator::make($request->all(), [
            'periode' => 'required|date_format:Y-m', // Format: YYYY-MM
            'cdi' => 'nullable|numeric',
            'bdi' => 'nullable|numeric',
            'odi' => 'nullable|numeric',
            'kuadrant' => 'nullable|integer|between:1,4',
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
            $koperasi = Koperasi::findOrFail($koperasiId);

            // Convert YYYY-MM to date (first day of month)
            $periodeDate = $request->periode . '-01';

            // Check if performa exists for this period
            $performa = Performa::where('koperasi_id', $koperasiId)
                ->whereYear('periode', substr($request->periode, 0, 4))
                ->whereMonth('periode', substr($request->periode, 5, 2))
                ->first();

            if ($performa) {
                // Update existing
                $performa->update([
                    'cdi' => $request->cdi,
                    'bdi' => $request->bdi,
                    'odi' => $request->odi,
                    'kuadrant' => $request->kuadrant,
                ]);
                $message = 'Performa updated successfully';
            } else {
                // Create new
                $performa = Performa::create([
                    'koperasi_id' => $koperasiId,
                    'periode' => $periodeDate,
                    'cdi' => $request->cdi,
                    'bdi' => $request->bdi,
                    'odi' => $request->odi,
                    'kuadrant' => $request->kuadrant,
                ]);

                // Create related records
                PerformaBisnis::create([
                    'performa_id' => $performa->id,
                    'responden_id' => $koperasi->responden_id,
                ]);

                PerformaOrganisasi::create([
                    'performa_id' => $performa->id,
                    'responden_id' => $koperasi->responden_id,
                ]);

                $message = 'Performa created successfully';
            }

            DB::commit();

            // Load relationships
            $performa->load([
                'performaBisnis',
                'performaOrganisasi'
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $performa
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save performa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete performa
     */
    public function destroy($koperasiId, $performaId)
    {
        DB::beginTransaction();
        try {
            $performa = Performa::where('koperasi_id', $koperasiId)
                ->where('id', $performaId)
                ->firstOrFail();

            $performa->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Performa deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete performa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
