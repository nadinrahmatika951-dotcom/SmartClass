<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mata_kuliah',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'dosen',
    ];

    /**
     * Relasi ke model User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi Many-to-Many untuk melihat siapa saja mahasiswa di kelas ini
     */
    public function mahasiswas()
    {
        return $this->belongsToMany(User::class, 'jadwal_user');
    }
}
