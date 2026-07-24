<x-app-layout>
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('jadwal.index') }}" class="p-2 bg-white rounded-xl shadow-sm text-gray-500 hover:text-primary transition-colors border border-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Tambah Jadwal Baru</h2>
            <p class="text-sm text-gray-500">Masukkan detail jadwal perkuliahan Anda.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-halus p-6 md:p-8 max-w-3xl mb-20 md:mb-0">
        <form action="{{ route('jadwal.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Mata Kuliah -->
                <div class="md:col-span-2">
                    <label for="mata_kuliah" class="block text-sm font-medium text-gray-700 mb-2">Mata Kuliah</label>
                    <input type="text" name="mata_kuliah" id="mata_kuliah" value="{{ old('mata_kuliah') }}" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring-primary shadow-sm" placeholder="Contoh: Pemrograman Web Lanjut" required>
                    @error('mata_kuliah') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Dosen Pengampu -->
                <div class="md:col-span-2">
                    <label for="dosen" class="block text-sm font-medium text-gray-700 mb-2">Dosen Pengampu</label>
                    <input type="text" name="dosen" id="dosen" value="{{ old('dosen') }}" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring-primary shadow-sm" placeholder="Nama Dosen beserta gelar" required>
                    @error('dosen') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Hari -->
                <div>
                    <label for="hari" class="block text-sm font-medium text-gray-700 mb-2">Hari</label>
                    <select name="hari" id="hari" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring-primary shadow-sm" required>
                        <option value="" disabled selected>Pilih Hari</option>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                            <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                    @error('hari') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Ruangan -->
                <div>
                    <label for="ruangan" class="block text-sm font-medium text-gray-700 mb-2">Ruangan</label>
                    <input type="text" name="ruangan" id="ruangan" value="{{ old('ruangan') }}" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring-primary shadow-sm" placeholder="Contoh: Lab Komputer 1" required>
                    @error('ruangan') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Jam Mulai -->
                <div>
                    <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring-primary shadow-sm" required>
                    @error('jam_mulai') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Jam Selesai -->
                <div>
                    <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-2">Jam Selesai</label>
                    <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}" class="w-full rounded-xl border-gray-300 focus:border-primary focus:ring-primary shadow-sm" required>
                    @error('jam_selesai') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('jadwal.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-xl font-medium hover:bg-red-800 transition-colors shadow-sm">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</x-app-layout>