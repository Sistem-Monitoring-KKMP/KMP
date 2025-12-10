<?php

namespace App\Http\Controllers\ManajemenKMP;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Koperasi;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LokasiKoperasiController extends Controller
{
    /**
     * Get lokasi by koperasi ID
     */
    public function getByKoperasiId($koperasiId)
    {
        try {
            // Check if koperasi exists
            $koperasi = Koperasi::find($koperasiId);
            if (!$koperasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koperasi tidak ditemukan'
                ], 404);
            }

            // Get all lokasi with relationships (bukan first())
            $lokasi = Lokasi::where('koperasi_id', $koperasiId)
                ->with(['kelurahan', 'kecamatan'])
                ->get(); // ✅ Ubah dari first() ke get()

            return response()->json([
                'success' => true,
                'message' => 'Get lokasi successfully',
                'data' => $lokasi // Array of lokasi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get lokasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save lokasi koperasi (Create if not exists, Update if exists)
     */
    public function saveLokasiKoperasi(Request $request, $koperasiId)
    {
        try {
            // Check if koperasi exists
            $koperasi = Koperasi::find($koperasiId);
            if (!$koperasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koperasi tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'kelurahan_id' => 'required|exists:kelurahan,id',
                'kecamatan_id' => 'required|exists:kecamatan,id',
                'alamat' => 'required|string|max:500',
                'longitude' => 'nullable|numeric|between:-180,180',
                'latitude' => 'nullable|numeric|between:-90,90',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();
            $data['koperasi_id'] = $koperasiId;

            DB::beginTransaction();

            try {
                // Check if lokasi already exists for this koperasi
                $lokasi = Lokasi::where('koperasi_id', $koperasiId)->first();

                if ($lokasi) {
                    // Update existing lokasi
                    $lokasi->update($data);
                    $message = 'Lokasi berhasil diperbarui';
                    $statusCode = 200;
                } else {
                    // Create new lokasi
                    $lokasi = Lokasi::create($data);
                    $message = 'Lokasi berhasil ditambahkan';
                    $statusCode = 201;
                }

                // Load relationships
                $lokasi->load(['koperasi', 'kelurahan', 'kecamatan']);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => $lokasi
                ], $statusCode);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save lokasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
