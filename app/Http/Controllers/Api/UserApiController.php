<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserApiController extends Controller
{
    // Menampilkan semua user
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);
    }

    // Mengubah role user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);

        if ($user->id === $request->user()->id) {
            return response()->json(['message' => 'Tidak bisa mengubah role sendiri'], 403);
        }

        $user->update(['role' => $request->role]);

        return response()->json([
            'status' => 'success',
            'message' => 'Role berhasil diperbarui',
            'data' => $user
        ], 200);
    }

    // Suspend / Aktifkan user
    public function toggleStatus(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return response()->json(['message' => 'Tidak bisa men-suspend akun sendiri'], 403);
        }

        $user->update([
            'status' => $user->status === 'active' ? 'suspended' : 'active'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status berhasil diubah menjadi ' . $user->status,
            'data' => $user
        ], 200);
    }

    // Menghapus user
    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return response()->json(['message' => 'Tidak bisa menghapus akun sendiri'], 403);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil dihapus'
        ], 200);
    }
}
