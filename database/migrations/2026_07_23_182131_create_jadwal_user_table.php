<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_user', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel jadwals
            $table->foreignId('jadwal_id')->constrained()->onDelete('cascade');
            // Menghubungkan ke tabel users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_user');
    }
};
