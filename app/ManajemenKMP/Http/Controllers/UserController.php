<?php

namespace App\ManajemenKMP\Http\Controllers;

use App\ManajemenKMP\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get all users with pagination and filters
     */
    public function index(Request $request)
    {
        try {
            // Validation untuk query parameters
            $validator = Validator::make($request->all(), [
                'page' => 'nullable|integer|min:1',
                'per_page' => 'nullable|integer|min:1|max:100',
                'role' => 'nullable|in:admin,anggota,superadmin',
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
            $query = User::with('anggota');

            // Filter by role
            if ($request->has('role') && !empty($request->role)) {
                $query->where('role', $request->role);
            }

            // Search by email or username
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            }

            // Pagination
            $perPage = $request->input('per_page', 10);
            $users = $query->orderBy('created_at', 'desc')->paginate($perPage);

            // Transform data
            $users->getCollection()->transform(function ($user) {
                $data = $user->toArray();

                // Add anggota info if exists
                if ($user->anggota) {
                    $data['anggota'] = [
                        'id' => $user->anggota->id,
                        'kode' => $user->anggota->kode,
                        'nama' => $user->anggota->nama,
                        'nik' => $user->anggota->nik,
                        'telp' => $user->anggota->telp,
                        'status' => $user->anggota->status,
                    ];
                }

                return $data;
            });

            return response()->json([
                'success' => true,
                'message' => 'Get all users successfully',
                'data' => $users->items(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                ]

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user by ID
     */
    public function show($id)
    {
        try {
            $user = User::with('anggota')->find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $data = $user->toArray();

            // Add complete anggota info if exists
            if ($user->anggota) {
                $data['anggota'] = $user->anggota->toArray();

                // Add image URLs
                $data['anggota']['foto_anggota_url'] = $user->anggota->foto_anggota ?
                    asset('storage/' . $user->anggota->foto_anggota) : null;
                $data['anggota']['ktp_url'] = $user->anggota->ktp ?
                    asset('storage/' . $user->anggota->ktp) : null;
                $data['anggota']['npwp_url'] = $user->anggota->npwp ?
                    asset('storage/' . $user->anggota->npwp) : null;
                $data['anggota']['nib_url'] = $user->anggota->nib ?
                    asset('storage/' . $user->anggota->nib) : null;
                $data['anggota']['pas_foto_url'] = $user->anggota->pas_foto ?
                    asset('storage/' . $user->anggota->pas_foto) : null;
            }

            return response()->json([
                'success' => true,
                'message' => 'Get user successfully',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new user
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:user,email|max:255',
                'username' => 'required|string|unique:user,username|max:255',
                'password' => 'required|string|min:6',
                'role' => 'required|in:admin,anggota,superadmin',
                'anggota_id' => 'nullable|uuid|exists:anggota,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Validate anggota_id if role is 'anggota'
            if ($request->role === 'anggota' && empty($request->anggota_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'anggota_id is required for role anggota'
                ], 422);
            }

            // Check if anggota already has a user account
            if ($request->anggota_id) {
                $existingUser = User::where('anggota_id', $request->anggota_id)->first();
                if ($existingUser) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This anggota already has a user account'
                    ], 422);
                }
            }

            $user = User::create($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'email' => 'sometimes|required|email|unique:user,email,' . $id . '|max:255',
                'username' => 'sometimes|required|string|unique:user,username,' . $id . '|max:255',
                'password' => 'nullable|string|min:6',
                'role' => 'sometimes|required|in:admin,anggota,superadmin',
                'anggota_id' => 'nullable|uuid|exists:anggota,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Validate anggota_id if role is being changed to 'anggota'
            if ($request->has('role') && $request->role === 'anggota' && empty($request->anggota_id) && empty($user->anggota_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'anggota_id is required for role anggota'
                ], 422);
            }

            // Check if anggota already has another user account
            if ($request->has('anggota_id') && $request->anggota_id) {
                $existingUser = User::where('anggota_id', $request->anggota_id)
                    ->where('id', '!=', $id)
                    ->first();

                if ($existingUser) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This anggota already has a user account'
                    ], 422);
                }
            }

            $data = $validator->validated();

            // Only update password if provided
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user by anggota_id
     */
    public function getByAnggotaId($anggotaId)
    {
        try {
            $user = User::with('anggota')->where('anggota_id', $anggotaId)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found for this anggota'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Get user successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change password
     */
    public function changePassword(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'old_password' => 'required|string',
                'new_password' => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Verify old password
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Old password is incorrect'
                ], 422);
            }

            // Update password
            $user->password = $request->new_password;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to change password',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
