<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        // Menampilkan semua user terbaru, dengan pagination
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    // Memperbarui role pengguna
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        // Mencegah admin menghapus/mengubah akses dirinya sendiri secara tidak sengaja
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak bisa mengubah role Anda sendiri.');
        }

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->route('users.index')->with('success', 'Hak akses pengguna berhasil diperbarui.');
    }

    // Menghapus pengguna (Opsional, untuk fitur suspend/delete)
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    // Fungsi untuk Suspend / Unsuspend
    public function toggleStatus(User $user)
    {
        // Cegah admin men-suspend dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak bisa men-suspend akun sendiri.');
        }

        // Ubah status (jika active jadi suspended, jika suspended jadi active)
        $user->update([
            'status' => $user->status === 'active' ? 'suspended' : 'active'
        ]);

        $pesan = $user->status === 'suspended' ? 'Akun berhasil di-suspend.' : 'Akun berhasil diaktifkan kembali.';
        return redirect()->route('users.index')->with('success', $pesan);
    }
}
