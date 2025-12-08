<?php

namespace App\Http\Controllers\ManajemenKMP;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KecamatanController extends Controller
{
    /**
     * Get all kecamatan
     */
    public function getAllKecamatan(Request $request)
    {
        try {
            // Validation untuk query parameters
            $validator = Validator::make($request->all(), [
                'search' => 'nullable|string|max:255',
                'sort_by' => 'nullable|in:nama,created_at',
                'sort_order' => 'nullable|in:asc,desc',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Query builder
            $query = Kecamatan::query();

            // Search by nama
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where('nama', 'like', "%{$search}%");
            }

            // Sorting
            $sortBy = $request->input('sort_by', 'nama');
            $sortOrder = $request->input('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);

            // Get all data without pagination
            $kecamatan = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Get all kecamatan successfully',
                'data' => $kecamatan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get kecamatan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
