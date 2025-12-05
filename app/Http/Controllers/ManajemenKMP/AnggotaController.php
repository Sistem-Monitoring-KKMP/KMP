<?php

namespace App\Http\Controllers\ManajemenKMP;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AnggotaController extends Controller
{
    /**
     * Get all anggota
     */
    public function index(Request $request)
    {
        try {
            // Validation untuk query parameters
            $validator = Validator::make($request->all(), [
                'page' => 'nullable|integer|min:1',
                'per_page' => 'nullable|integer|min:1|max:100',
                'koperasi_ids' => 'nullable|string',
                'status' => 'nullable|in:AKTIF,NON-AKTIF',
                'search' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Query builder
            $query = Anggota::query();

            // Filter by koperasi_ids (comma separated)
            if ($request->has('koperasi_ids') && !empty($request->koperasi_ids)) {
                $koperasiIds = explode(',', $request->koperasi_ids);
                $koperasiIds = array_map('trim', $koperasiIds); // Remove whitespace
                $query->whereIn('koperasi_id', $koperasiIds);
            }

            // Filter by status
            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }

            // Search by nama, kode, or nik
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('kode', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                });
            }

            // Pagination
            $perPage = $request->input('per_page', 10); // Default 10 items per page
            $anggota = $query->orderBy('created_at', 'desc')->paginate($perPage);

            // Transform data
            $anggota->getCollection()->transform(function ($item) {
                $data = $item->toArray();

                $gatewayUrl = env('GATEWAY_URL', 'http://localhost:8080');
                $data['foto_anggota_url'] = $item->foto_anggota ? $gatewayUrl . '/storage/' . $item->foto_anggota : null;
                $data['ktp_url'] = $item->ktp ? $gatewayUrl . '/storage/' . $item->ktp : null;
                $data['npwp_url'] = $item->npwp ? $gatewayUrl . '/storage/' . $item->npwp : null;
                $data['nib_url'] = $item->nib ? $gatewayUrl . '/storage/' . $item->nib : null;
                $data['pas_foto_url'] = $item->pas_foto ? $gatewayUrl . '/storage/' . $item->pas_foto : null;


                return $data;
            });

            return response()->json([
                'success' => true,
                'message' => 'Get all anggota successfully',
                'data' => $anggota->items(),
                'pagination' => [
                    'current_page' => $anggota->currentPage(),
                    'per_page' => $anggota->perPage(),
                    'total' => $anggota->total(),
                    'last_page' => $anggota->lastPage(),
                    'from' => $anggota->firstItem(),
                    'to' => $anggota->lastItem(),
                ],

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get anggota',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get anggota by ID
     */
    public function show(Request $request, $id)
    {
        try {
            $anggota = Anggota::find($id);

            if (!$anggota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota not found'
                ], 404);
            }

            $data = $anggota->toArray();

            // Get koperasi data
            if ($anggota->koperasi_id) {
                $token = $request->header('Authorization');
                $koperasi = $this->getKoperasiById($anggota->koperasi_id, $token);
                $data['koperasi'] = $koperasi;
            }

            // Add full URL for images melalui gateway
            $gatewayUrl = env('GATEWAY_URL', 'http://localhost:8080');
            $data['foto_anggota_url'] = $anggota->foto_anggota ? $gatewayUrl . '/storage/' . $anggota->foto_anggota : null;
            $data['ktp_url'] = $anggota->ktp ? $gatewayUrl . '/storage/' . $anggota->ktp : null;
            $data['npwp_url'] = $anggota->npwp ? $gatewayUrl . '/storage/' . $anggota->npwp : null;
            $data['nib_url'] = $anggota->nib ? $gatewayUrl . '/storage/' . $anggota->nib : null;
            $data['pas_foto_url'] = $anggota->pas_foto ? $gatewayUrl . '/storage/' . $anggota->pas_foto : null;

            return response()->json([
                'success' => true,
                'message' => 'Get anggota successfully',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get anggota',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new anggota
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kode' => 'required|string|unique:anggota,kode|max:255',
                'nama' => 'required|string|max:255',
                'nik' => 'required|string|size:16|unique:anggota,nik',
                'telp' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'tempat_lahir' => 'nullable|string|max:255',
                'tanggal_lahir' => 'nullable|date',
                'kelurahan' => 'nullable|string|max:255',
                'kecamatan' => 'nullable|string|max:255',
                'kota_kab' => 'nullable|string|max:255',
                'keterangan' => 'nullable|string',
                'jenis_kelamin' => 'nullable|in:L,P',
                'pekerjaan' => 'nullable|string|max:255',
                'foto_anggota' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'npwp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'nib' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'nullable|in:AKTIF,NON-AKTIF',
                'koperasi_id' => 'required|uuid',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Handle file uploads
            $data = $this->handleFileUploads($request, $data);

            $anggota = Anggota::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Anggota created successfully',
                'data' => $anggota
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create anggota',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update anggota
     */
    public function update(Request $request, $id)
    {
        try {
            $anggota = Anggota::find($id);

            if (!$anggota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'kode' => 'sometimes|required|string|unique:anggota,kode,' . $id . '|max:255',
                'nama' => 'sometimes|required|string|max:255',
                'nik' => 'sometimes|required|string|size:16|unique:anggota,nik,' . $id,
                'telp' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'tempat_lahir' => 'nullable|string|max:255',
                'tanggal_lahir' => 'nullable|date',
                'kelurahan' => 'nullable|string|max:255',
                'kecamatan' => 'nullable|string|max:255',
                'kota_kab' => 'nullable|string|max:255',
                'keterangan' => 'nullable|string',
                'jenis_kelamin' => 'nullable|in:L,P',
                'pekerjaan' => 'nullable|string|max:255',
                'foto_anggota' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'npwp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'nib' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'nullable|in:AKTIF,NON-AKTIF',
                'koperasi_id' => 'sometimes|required|uuid',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Validate koperasi exists if koperasi_id is being updated
            if ($request->has('koperasi_id')) {
                $token = $request->header('Authorization');
                $koperasiExists = $this->validateKoperasiExists($request->koperasi_id, $token);

                if (!$koperasiExists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Koperasi not found'
                    ], 404);
                }
            }

            $data = $validator->validated();

            // Handle file uploads and delete old files
            $data = $this->handleFileUploads($request, $data, $anggota);

            $anggota->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Anggota updated successfully',
                'data' => $anggota
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update anggota',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete anggota
     */
    public function destroy($id)
    {
        try {
            $anggota = Anggota::find($id);

            if (!$anggota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota not found'
                ], 404);
            }

            // Delete all associated files
            $this->deleteAnggotaFiles($anggota);

            $anggota->delete();

            return response()->json([
                'success' => true,
                'message' => 'Anggota deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete anggota',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper: Handle file uploads
     */
    private function handleFileUploads(Request $request, array $data, ?Anggota $anggota = null): array
    {
        $fileFields = [
            'foto_anggota' => 'anggota/foto',
            'ktp' => 'anggota/ktp',
            'npwp' => 'anggota/npwp',
            'nib' => 'anggota/nib',
            'pas_foto' => 'anggota/pas_foto',
        ];

        foreach ($fileFields as $field => $folder) {
            if ($request->hasFile($field)) {
                // Delete old file if updating
                if ($anggota && $anggota->$field) {
                    Storage::disk('public')->delete($anggota->$field);
                }

                // Store new file
                $file = $request->file($field);
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($folder, $filename, 'public');
                $data[$field] = $path;
            } else {
                // Remove field from data if no file uploaded
                unset($data[$field]);
            }
        }

        return $data;
    }

    /**
     * Helper: Delete all anggota files
     */
    private function deleteAnggotaFiles(Anggota $anggota): void
    {
        $fileFields = ['foto_anggota', 'ktp', 'npwp', 'nib', 'pas_foto'];

        foreach ($fileFields as $field) {
            if ($anggota->$field) {
                Storage::disk('public')->delete($anggota->$field);
            }
        }
    }

    // /**
    //  * Helper: Get koperasi by ID from koperasi service
    //  */
    // private function getKoperasiById(string $koperasiId, ?string $token = null): ?array
    // {
    //     try {
    //         $headers = [];
    //         if ($token) {
    //             $headers['Authorization'] = $token;
    //         }

    //         $response = Http::withHeaders($headers)
    //             ->timeout(5)
    //             ->get("http://localhost:8002/api/koperasi/{$koperasiId}");

    //         if ($response->successful()) {
    //             return $response->json('data');
    //         }

    //         return null;
    //     } catch (\Exception $e) {
    //         \Log::error("Failed to fetch koperasi: " . $e->getMessage());
    //         return null;
    //     }
    // }

    // /**
    //  * Helper: Validate if koperasi exists
    //  */
    // private function validateKoperasiExists(string $koperasiId, ?string $token = null): bool
    // {
    //     $koperasi = $this->getKoperasiById($koperasiId, $token);
    //     return $koperasi !== null;
    // }

    // /**
    //  * Helper: Get multiple koperasi by IDs
    //  */
    // private function getKoperasiByIds(array $koperasiIds, ?string $token = null): array
    // {
    //     try {
    //         $headers = [];
    //         if ($token) {
    //             $headers['Authorization'] = $token;
    //         }

    //         $response = Http::withHeaders($headers)
    //             ->timeout(5)
    //             ->post("http://localhost:8002/api/koperasi/batch", [
    //                 'ids' => $koperasiIds
    //             ]);

    //         if ($response->successful()) {
    //             return $response->json('data', []);
    //         }

    //         return [];
    //     } catch (\Exception $e) {
    //         \Log::error("Failed to fetch koperasi batch: " . $e->getMessage());
    //         return [];
    //     }
    // }
}
