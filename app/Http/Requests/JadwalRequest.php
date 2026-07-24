<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Otorisasi akan ditangani oleh Policy nanti
    }

    public function rules(): array
    {
        return [
            'mata_kuliah' => ['required', 'string', 'max:255'],
            'hari'        => ['required', 'string', 'max:20'],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'ruangan'     => ['required', 'string', 'max:50'],
            'dosen'       => ['required', 'string', 'max:255'],
        ];
    }
}