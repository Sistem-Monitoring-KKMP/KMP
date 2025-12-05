<?php

namespace App\Http\Controllers\ManajemenKMP;

use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class KoperasiController extends Controller
{
    /**
     * Get all koperasi with pagination and filters
     */
    public function index(Request $request)
    {
        try {
            // Validation untuk query parameters
            $validator = Validator::make($request->all(), [
                'page' => 'nullable|integer|min:1',
                'per_page' => 'nullable|integer|min:1|max:100',
                'search' => 'nullable|string|max:255',
                'sort_by' => 'nullable|in:nama,kontak,created_at',
                'sort_order' => 'nullable|in:asc,desc',
                'returnAll' => 'nullable|in:true,false,1,0',
                'status' => 'nullable|in:Aktif,TidakAktif,Pembentukan',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Query builder
            $query = Koperasi::query();

            // Filter by koperasi_ids (comma separated)
            if ($request->has('koperasi_ids') && !empty($request->koperasi_ids)) {
                $koperasiIds = explode(',', $request->koperasi_ids);
                $koperasiIds = array_map('trim', $koperasiIds); // Remove whitespace
                $query->whereIn('id', $koperasiIds);
            }

            // Search by nama
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where('nama', 'like', "%{$search}%");
            }

            // Filter by status
            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }

            // Sorting
            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = $request->input('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Check if returnAll is true
            $returnAll = filter_var($request->input('returnAll', false), FILTER_VALIDATE_BOOLEAN);

            if ($returnAll) {
                $koperasi = $query->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Get all koperasi successfully',
                    'data' => $koperasi,
                ], 200);
            }

            // Pagination
            $perPage = $request->input('per_page', 10);
            $koperasi = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Get all koperasi successfully',
                'data' => $koperasi->items(),
                'pagination' => [
                    'current_page' => $koperasi->currentPage(),
                    'per_page' => $koperasi->perPage(),
                    'total' => $koperasi->total(),
                    'last_page' => $koperasi->lastPage(),
                    'from' => $koperasi->firstItem(),
                    'to' => $koperasi->lastItem(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get koperasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get koperasi by ID
     */
    public function show($id)
    {
        try {
            $koperasi = Koperasi::with(['pengurus', 'lokasi', 'pengawas', 'performa'])->find($id);

            if (!$koperasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koperasi not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Get koperasi successfully',
                'data' => $koperasi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get koperasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new koperasi
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'kontak' => 'nullable|string|max:20',
                'no_badan_hukum' => 'nullable|string|max:255',
                'tahun' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
                'status' => 'nullable|in:Aktif,TidakAktif,Pembentukan',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Set default status if not provided
            if (!isset($data['status'])) {
                $data['status'] = 'Aktif';
            }

            $koperasi = Koperasi::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Koperasi created successfully',
                'data' => $koperasi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create koperasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update koperasi
     */
    public function update(Request $request, $id)
    {
        try {
            $koperasi = Koperasi::find($id);

            if (!$koperasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koperasi not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'nama' => 'sometimes|required|string|max:255',
                'kontak' => 'nullable|string|max:20',
                'no_badan_hukum' => 'nullable|string|max:255',
                'tahun' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
                'status' => 'nullable|in:Aktif,TidakAktif,Pembentukan',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();
            $koperasi->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Koperasi updated successfully',
                'data' => $koperasi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update koperasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete koperasi
     */
    public function destroy($id)
    {
        try {
            $koperasi = Koperasi::find($id);

            if (!$koperasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koperasi not found'
                ], 404);
            }

            // Check if koperasi has related data
            $hasPengurus = $koperasi->pengurus()->exists();
            $hasLokasi = $koperasi->lokasi()->exists();
            $hasPengawas = $koperasi->pengawas()->exists();
            $hasPerforma = $koperasi->performa()->exists();

            if ($hasPengurus || $hasLokasi || $hasPengawas || $hasPerforma) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete koperasi. It has related data (pengurus, lokasi, pengawas, or performa)'
                ], 409);
            }

            $koperasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Koperasi deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete koperasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}