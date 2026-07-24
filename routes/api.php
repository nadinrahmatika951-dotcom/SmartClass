<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Api\JadwalApiController;
use App\Http\Controllers\Api\UserApiController;

// ==========================================
// 1. ENDPOINT AUTHENTICATION (PUBLIC)
// ==========================================
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Kredensial tidak valid'], 401);
    }

    if ($user->status === 'suspended') {
        return response()->json(['message' => 'Akun Anda telah di-suspend'], 403);
    }

    return response()->json([
        'status' => 'success',
        'token' => $user->createToken('API Token')->plainTextToken,
        'user' => $user
    ]);
});

// ==========================================
// 2. ENDPOINT YANG DILINDUNGI TOKEN (PROTECTED)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {

    // --- FITUR PROFILE (Semua Role) ---
    Route::get('/profile', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ], 200);
    });

    // --- FITUR JADWAL (Read-Only untuk Mahasiswa) ---
    Route::get('/jadwal', [JadwalApiController::class, 'index']);
    Route::get('/jadwal/{jadwal}', [JadwalApiController::class, 'show']);

    // --- FITUR KHUSUS ADMIN ---
    Route::middleware('role:admin')->group(function () {

        // Manajemen Jadwal
        Route::post('/jadwal', [JadwalApiController::class, 'store']);
        Route::put('/jadwal/{jadwal}', [JadwalApiController::class, 'update']);
        Route::delete('/jadwal/{jadwal}', [JadwalApiController::class, 'destroy']);

        // Manajemen User
        Route::get('/users', [UserApiController::class, 'index']);
        Route::put('/users/{user}', [UserApiController::class, 'update']);
        Route::patch('/users/{user}/toggle-status', [UserApiController::class, 'toggleStatus']);
        Route::delete('/users/{user}', [UserApiController::class, 'destroy']);
    });

    // --- LOGOUT ---
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Berhasil logout'], 200);
    });
});
