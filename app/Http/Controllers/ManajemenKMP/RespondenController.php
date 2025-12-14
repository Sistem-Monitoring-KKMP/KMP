<?php
// filepath: c:\Users\mrizk\Desktop\Code\KMP\KMP-Backend\app\Http\Controllers\ManajemenKMP\RespondenController.php

namespace App\Http\Controllers\ManajemenKMP;

use App\Http\Controllers\Controller;
use App\Models\Responden;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RespondenController extends Controller
{
    /**
     * Get responden by koperasi_id
     */
    public function getByKoperasiId($koperasiId)
    {
        try {
            $koperasi = Koperasi::with('responden')->findOrFail($koperasiId);

            return response()->json([
                'success' => true,
                'message' => 'Get responden successfully',
                'data' => $koperasi->responden
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get responden',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store or update responden for koperasi
     */
    public function saveResponden(Request $request, $koperasiId)
    {
        $validator = Validator::make($request->all(), [
            'responden' => 'required|string|max:255',
            'kontak_responden' => 'required|string|max:20',
            'enumerator' => 'required|string|max:255',
            'kontak_enumerator' => 'required|string|max:20',
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

            // Check if responden already exists for this koperasi
            if ($koperasi->responden_id) {
                // Update existing responden
                $responden = Responden::findOrFail($koperasi->responden_id);
                $responden->update([
                    'responden' => $request->responden,
                    'kontak_responden' => $request->kontak_responden,
                    'enumerator' => $request->enumerator,
                    'kontak_enumerator' => $request->kontak_enumerator,
                ]);

                $message = 'Responden updated successfully';
            } else {
                // Create new responden
                $responden = Responden::create([
                    'responden' => $request->responden,
                    'kontak_responden' => $request->kontak_responden,
                    'enumerator' => $request->enumerator,
                    'kontak_enumerator' => $request->kontak_enumerator,
                ]);

                // Link responden to koperasi
                $koperasi->update(['responden_id' => $responden->id]);

                $message = 'Responden created successfully';
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $responden
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save responden',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete responden (unlink from koperasi)
     */
    public function destroy($koperasiId)
    {
        DB::beginTransaction();
        try {
            $koperasi = Koperasi::findOrFail($koperasiId);

            if (!$koperasi->responden_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Responden not found for this koperasi'
                ], 404);
            }

            $respondenId = $koperasi->responden_id;

            // Unlink responden from koperasi
            $koperasi->update(['responden_id' => null]);

            // Delete responden if not used by other koperasi
            $isUsedByOthers = Koperasi::where('responden_id', $respondenId)
                ->where('id', '!=', $koperasiId)
                ->exists();

            if (!$isUsedByOthers) {
                Responden::destroy($respondenId);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Responden deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete responden',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
