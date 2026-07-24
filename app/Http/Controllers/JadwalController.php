<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Http\Requests\JadwalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JadwalController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Jadwal::query();

        // Jika user adalah mahasiswa, hanya tampilkan jadwalnya sendiri
        if (Auth::user()->role === 'mahasiswa') {
            $query->where('user_id', Auth::id());
        }

        // Fitur Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('mata_kuliah', 'like', "%{$search}%")
                    ->orWhere('dosen', 'like', "%{$search}%");
            });
        }

        $jadwals = $query->orderBy('hari')->orderBy('jam_mulai')->get();
        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        return view('jadwal.create');
    }

    public function store(JadwalRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->jadwals()->create($request->validated());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        $this->authorize('update', $jadwal);
        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(JadwalRequest $request, Jadwal $jadwal)
    {
        $this->authorize('update', $jadwal);
        $jadwal->update($request->validated());
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $this->authorize('delete', $jadwal);
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    // Menampilkan halaman Roster (Kelas yang diambil)
    public function roster()
    {
        // Mengambil data jadwal khusus untuk user yang sedang login
        $jadwals = auth()->user()->roster;
        return view('jadwal.roster', compact('jadwals'));
    }

    // Mengambil kelas (Enroll)
    public function enroll(Request $request, \App\Models\Jadwal $jadwal)
    {
        // Mencegah duplikasi data (syncWithoutDetaching)
        $request->user()->roster()->syncWithoutDetaching([$jadwal->id]);

        return redirect()->back()->with('success', 'Berhasil mengambil kelas ' . $jadwal->mata_kuliah);
    }

    // Membatalkan kelas (Drop)
    public function drop(Request $request, \App\Models\Jadwal $jadwal)
    {
        $request->user()->roster()->detach($jadwal->id);

        return redirect()->back()->with('success', 'Berhasil membatalkan kelas ' . $jadwal->mata_kuliah);
    }

    public function exportPdf()
    {
        // Admin bisa cetak semua, Mahasiswa cetak miliknya sendiri
        $jadwals = Auth::user()->role === 'admin'
            ? Jadwal::with('user')->get()
            : Jadwal::where('user_id', Auth::id())->get();

        $pdf = Pdf::loadView('jadwal.pdf', compact('jadwals'));
        return $pdf->download('jadwal-kuliah.pdf');
    }
}
