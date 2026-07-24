<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $totalMataKuliah = Jadwal::count();
            $jadwalHariIni = Jadwal::where('hari', $this->getHariIni())->count();
            $jumlahDosen = Jadwal::distinct('dosen')->count('dosen');
            $jumlahUser = User::where('role', 'mahasiswa')->count();
        } else {
            $totalMataKuliah = Jadwal::where('user_id', $user->id)->count();
            $jadwalHariIni = Jadwal::where('user_id', $user->id)->where('hari', $this->getHariIni())->count();
            $jumlahDosen = Jadwal::where('user_id', $user->id)->distinct('dosen')->count('dosen');
            $jumlahUser = null; 
        }

        return view('dashboard', compact('totalMataKuliah', 'jadwalHariIni', 'jumlahDosen', 'jumlahUser'));
    }

    private function getHariIni()
    {
        $hariInggris = date('l');
        $mapHari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        return $mapHari[$hariInggris];
    }
}