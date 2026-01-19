<?php

namespace App\Http\Controllers\ManajemenKMP;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * Get list of active koperasi for registration dropdown
     */
    public function getActiveKoperasi()
    {
        try {
            $koperasi = Koperasi::select('id', 'nama', 'kontak')
                ->orderBy('nama', 'asc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => (string) $item->id,
                        'nama' => $item->nama,
                        'kontak' => $item->kontak,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Get active koperasi successfully',
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
     * Register new anggota with user account
     */
    public function register(Request $request)
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                // Anggota data
                'nama' => 'required|string|max:255',
                'nik' => 'required|string|size:16|unique:anggota,nik',
                'telp' => 'required|string|max:20',
                'alamat' => 'required|string',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date|before:today',
                'kelurahan' => 'required|string|max:255',
                'kecamatan' => 'required|string|max:255',
                'kota_kab' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'pekerjaan' => 'required|string|max:255',
                'koperasi_id' => 'required|exists:koperasi,id',

                // User account data
                'email' => 'required|email|unique:user,email|max:255',
                'username' => 'required|string|unique:user,username|max:255|min:4',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|string|min:6',

                // Optional files
                'foto_anggota' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'npwp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'nib' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Start transaction
            DB::beginTransaction();

            try {
                // Generate unique kode for anggota
                $kode = $this->generateKodeAnggota($request->koperasi_id);

                // Prepare anggota data
                $anggotaData = [
                    'id' => (string) Str::uuid(),
                    'kode' => $kode,
                    'nama' => $request->nama,
                    'nik' => $request->nik,
                    'telp' => $request->telp,
                    'alamat' => $request->alamat,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'kelurahan' => $request->kelurahan,
                    'kecamatan' => $request->kecamatan,
                    'kota_kab' => $request->kota_kab,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'pekerjaan' => $request->pekerjaan,
                    'koperasi_id' => $request->koperasi_id,
                    'status' => 'AKTIF', // Default status
                    'keterangan' => 'Pendaftaran mandiri',
                ];

                // Handle file uploads
                if ($request->hasFile('foto_anggota')) {
                    $anggotaData['foto_anggota'] = $request->file('foto_anggota')->store('anggota/foto', 'public');
                }
                if ($request->hasFile('ktp')) {
                    $anggotaData['ktp'] = $request->file('ktp')->store('anggota/ktp', 'public');
                }
                if ($request->hasFile('npwp')) {
                    $anggotaData['npwp'] = $request->file('npwp')->store('anggota/npwp', 'public');
                }
                if ($request->hasFile('nib')) {
                    $anggotaData['nib'] = $request->file('nib')->store('anggota/nib', 'public');
                }
                if ($request->hasFile('pas_foto')) {
                    $anggotaData['pas_foto'] = $request->file('pas_foto')->store('anggota/pas_foto', 'public');
                }

                // Create anggota
                $anggota = Anggota::create($anggotaData);

                // Create user account
                $user = User::create([
                    'id' => (string) Str::uuid(),
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'role' => 'anggota',
                    'anggota_id' => $anggota->id,
                ]);

                // Commit transaction
                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Registrasi berhasil! Silakan login menggunakan email dan password Anda.',
                    'data' => [
                        'anggota' => [
                            'id' => $anggota->id,
                            'kode' => $anggota->kode,
                            'nama' => $anggota->nama,
                            'nik' => $anggota->nik,
                        ],
                        'user' => [
                            'id' => $user->id,
                            'email' => $user->email,
                            'username' => $user->username,
                        ]
                    ]
                ], 201);
            } catch (\Exception $e) {
                // Rollback transaction
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate unique kode anggota
     * Format: KOP-{KOPERASI_CODE}-{SEQUENCE}
     */
    private function generateKodeAnggota($koperasiId)
    {
        // Get koperasi
        $koperasi = Koperasi::find($koperasiId);

        // Get last anggota kode for this koperasi
        $lastAnggota = Anggota::where('koperasi_id', $koperasiId)
            ->orderBy('created_at', 'desc')
            ->first();

        // Generate sequence number
        $sequence = 1;
        if ($lastAnggota && $lastAnggota->kode) {
            // Extract sequence from last kode
            $parts = explode('-', $lastAnggota->kode);
            if (count($parts) >= 3) {
                $lastSequence = intval(end($parts));
                $sequence = $lastSequence + 1;
            }
        }

        // Create koperasi code (first 3 letters, uppercase)
        $koperasiCode = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $koperasi->nama), 0, 3));
        if (strlen($koperasiCode) < 3) {
            $koperasiCode = str_pad($koperasiCode, 3, 'X');
        }

        // Format: KOP-XXX-0001
        return sprintf('KOP-%s-%04d', $koperasiCode, $sequence);
    }

    /**
     * Check if email is available
     */
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email format'
            ], 422);
        }

        $exists = User::where('email', $request->email)->exists();

        return response()->json([
            'success' => true,
            'available' => !$exists,
            'message' => $exists ? 'Email sudah terdaftar' : 'Email tersedia'
        ], 200);
    }

    /**
     * Check if username is available
     */
    public function checkUsername(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username format'
            ], 422);
        }

        $exists = User::where('username', $request->username)->exists();

        return response()->json([
            'success' => true,
            'available' => !$exists,
            'message' => $exists ? 'Username sudah digunakan' : 'Username tersedia'
        ], 200);
    }

    /**
     * Check if NIK is available
     */
    public function checkNik(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'NIK harus 16 digit'
            ], 422);
        }

        $exists = Anggota::where('nik', $request->nik)->exists();

        return response()->json([
            'success' => true,
            'available' => !$exists,
            'message' => $exists ? 'NIK sudah terdaftar' : 'NIK tersedia'
        ], 200);
    }
}
