<?php

namespace App\Policies;

use App\Models\Jadwal;
use App\Models\User;

class JadwalPolicy
{
    /**
     * Admin bisa melakukan segalanya. Ini akan dijalankan sebelum method policy lainnya.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    public function update(User $user, Jadwal $jadwal): bool
    {
        return $user->id === $jadwal->user_id;
    }

    public function delete(User $user, Jadwal $jadwal): bool
    {
        return $user->id === $jadwal->user_id;
    }
}