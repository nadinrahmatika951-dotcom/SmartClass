<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk semua user yang sudah login (Admin & User)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Fitur User: Lihat Jadwal (Read-Only)
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');

    //Rute untuk Fitur Roster
    Route::get('/roster', [JadwalController::class, 'roster'])->name('jadwal.roster');
    Route::post('/jadwal/{jadwal}/enroll', [JadwalController::class, 'enroll'])->name('jadwal.enroll');
    Route::delete('/jadwal/{jadwal}/drop', [JadwalController::class, 'drop'])->name('jadwal.drop');

    // Fitur User: Kelola Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route khusus ADMIN
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // Manajemen Jadwal (Create, Update, Delete)
    Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

    // Rute Suspend User
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::resource('users', UserController::class)->except(['create', 'store', 'show']);

    // Export Laporan
    Route::get('/jadwal-pdf', [JadwalController::class, 'exportPdf'])->name('jadwal.pdf');

    // User Management (Lihat daftar user, ubah role, dll)
    Route::resource('users', UserController::class)->except(['create', 'store', 'show']);
});

require __DIR__ . '/auth.php';
