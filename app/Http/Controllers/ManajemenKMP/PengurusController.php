<?php

namespace App\Http\Controllers\ManajemenKMP;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use App\Models\LatarBelakang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PengurusController extends Controller
{
    /**
     * Get all pengurus by koperasi_id
     */
    public function getByKoperasiId($koperasiId)
    {
        try {
            $pengurus = Pengurus::with('latarBelakang')
                ->where('koperasi_id', $koperasiId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Get pengurus successfully',
                'data' => $pengurus
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get pengurus',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new pengurus
     */
    public function store(Request $request, $koperasiId)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|in:Ketua,WakilBU,WakilBA,Sekretaris,Bendahara,KetuaPengawas,Pengawas,GeneralManager',
            'jenis_kelamin' => 'required|in:L,P',
            'usia' => 'nullable|integer|min:17|max:100',
            'pendidikan_koperasi' => 'boolean',
            'pendidikan_ekonomi' => 'boolean',
            'pelatihan_koperasi' => 'boolean',
            'pelatihan_bisnis' => 'boolean',
            'pelatihan_lainnya' => 'boolean',
            'tingkat_pendidikan' => 'nullable|in:sd,sltp,slta,diploma,sarjana,pascasarjana',
            'keaktifan_kkmp' => 'nullable|in:aktif,cukup aktif,kurang aktif',
            'latar_belakang' => 'nullable|array',
            'latar_belakang.*' => 'in:koperasi,bisnis,ASN,militer/polisi,politik,organisasi'
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
            // Create pengurus
            $pengurus = Pengurus::create([
                'koperasi_id' => $koperasiId,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia' => $request->usia,
                'pendidikan_koperasi' => $request->pendidikan_koperasi ?? false,
                'pendidikan_ekonomi' => $request->pendidikan_ekonomi ?? false,
                'pelatihan_koperasi' => $request->pelatihan_koperasi ?? false,
                'pelatihan_bisnis' => $request->pelatihan_bisnis ?? false,
                'pelatihan_lainnya' => $request->pelatihan_lainnya ?? false,
                'tingkat_pendidikan' => $request->tingkat_pendidikan,
                'keaktifan_kkmp' => $request->keaktifan_kkmp
            ]);

            // Create latar belakang
            if ($request->has('latar_belakang') && is_array($request->latar_belakang)) {
                foreach ($request->latar_belakang as $lb) {
                    LatarBelakang::create([
                        'pengurus_id' => $pengurus->id,
                        'latarbelakang' => $lb
                    ]);
                }
            }

            DB::commit();

            $pengurus->load('latarBelakang');

            return response()->json([
                'success' => true,
                'message' => 'Pengurus created successfully',
                'data' => $pengurus
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create pengurus',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update pengurus
     */
    public function update(Request $request, $koperasiId, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|in:Ketua,WakilBU,WakilBA,Sekretaris,Bendahara,KetuaPengawas,Pengawas,GeneralManager',
            'jenis_kelamin' => 'required|in:L,P',
            'usia' => 'nullable|integer|min:17|max:100',
            'pendidikan_koperasi' => 'boolean',
            'pendidikan_ekonomi' => 'boolean',
            'pelatihan_koperasi' => 'boolean',
            'pelatihan_bisnis' => 'boolean',
            'pelatihan_lainnya' => 'boolean',
            'tingkat_pendidikan' => 'nullable|in:sd,sltp,slta,diploma,sarjana,pascasarjana',
            'keaktifan_kkmp' => 'nullable|in:aktif,cukup aktif,kurang aktif',
            'latar_belakang' => 'nullable|array',
            'latar_belakang.*' => 'in:koperasi,bisnis,ASN,militer/polisi,politik,organisasi'
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
            $pengurus = Pengurus::where('koperasi_id', $koperasiId)->findOrFail($id);

            $pengurus->update([
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia' => $request->usia,
                'pendidikan_koperasi' => $request->pendidikan_koperasi ?? false,
                'pendidikan_ekonomi' => $request->pendidikan_ekonomi ?? false,
                'pelatihan_koperasi' => $request->pelatihan_koperasi ?? false,
                'pelatihan_bisnis' => $request->pelatihan_bisnis ?? false,
                'pelatihan_lainnya' => $request->pelatihan_lainnya ?? false,
                'tingkat_pendidikan' => $request->tingkat_pendidikan,
                'keaktifan_kkmp' => $request->keaktifan_kkmp
            ]);

            // Update latar belakang
            LatarBelakang::where('pengurus_id', $pengurus->id)->delete();
            if ($request->has('latar_belakang') && is_array($request->latar_belakang)) {
                foreach ($request->latar_belakang as $lb) {
                    LatarBelakang::create([
                        'pengurus_id' => $pengurus->id,
                        'latarbelakang' => $lb
                    ]);
                }
            }

            DB::commit();

            $pengurus->load('latarBelakang');

            return response()->json([
                'success' => true,
                'message' => 'Pengurus updated successfully',
                'data' => $pengurus
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update pengurus',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete pengurus
     */
    public function destroy($koperasiId, $id)
    {
        try {
            $pengurus = Pengurus::where('koperasi_id', $koperasiId)->findOrFail($id);
            $pengurus->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pengurus deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete pengurus',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
