<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalApiController extends Controller
{
    // READ: Tampilkan semua jadwal
    public function index()
    {
        $jadwal = Jadwal::all();
        return response()->json([
            'status' => 'success',
            'data' => $jadwal
        ], 200);
    }

    // CREATE: Tambah jadwal baru (Khusus Admin)
    public function store(Request $request)
    {
        // Sesuaikan validasi dengan struktur tabel
        $validated = $request->validate([
            'mata_kuliah' => 'required|string',
            'dosen' => 'required|string',
            'hari' => 'required|string',
            'jam_mulai' => 'required|string',
            'jam_selesai' => 'required|string',
            'ruangan' => 'required|string',
        ]);

        // Masukkan ID admin yang login
        $validated['user_id'] = $request->user()->id;

        $jadwal = Jadwal::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil ditambahkan',
            'data' => $jadwal
        ], 201);
    }

    // READ: Tampilkan satu jadwal spesifik
    public function show(Jadwal $jadwal)
    {
        return response()->json([
            'status' => 'success',
            'data' => $jadwal
        ], 200);
    }

    // UPDATE: Edit jadwal (Khusus Admin)
    public function update(Request $request, Jadwal $jadwal)
    {
        // Sesuaikan validasi dengan struktur tabel
        $validated = $request->validate([
            'mata_kuliah' => 'required|string',
            'dosen' => 'required|string',
            'hari' => 'required|string',
            'jam_mulai' => 'required|string',
            'jam_selesai' => 'required|string',
            'ruangan' => 'required|string',
        ]);

        $jadwal->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil diubah',
            'data' => $jadwal
        ], 200);
    }

    // DELETE: Hapus jadwal (Khusus Admin)
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil dihapus'
        ], 200);
    }
}
