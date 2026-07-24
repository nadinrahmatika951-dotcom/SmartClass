<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Jadwal Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Flash Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-3 sm:space-y-0">
                        <h3 class="text-lg font-medium text-gray-900">Jadwal Mata Kuliah Induk</h3>

                        <!-- Tombol Tambah & Export HANYA UNTUK ADMIN -->
                        @if (auth()->user()->role === 'admin')
                            <div class="flex space-x-2">
                                <a href="{{ route('jadwal.pdf') }}"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                                    Cetak PDF
                                </a>
                                <a href="{{ route('jadwal.create') }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                                    + Tambah Jadwal
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Wrapper responsif -->
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto shadow-sm rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Mata Kuliah</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dosen</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Hari & Jam</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ruangan</th>

                                    @if (auth()->user()->role === 'admin')
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi Admin</th>
                                    @else
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ambil Kelas</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($jadwals as $index => $jadwal)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                            {{ $jadwal->mata_kuliah }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $jadwal->dosen }}</td>

                                        <!-- PERBAIKAN: Menampilkan jam_mulai dan jam_selesai -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $jadwal->hari }}, {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $jadwal->ruangan }}</td>

                                        @if (auth()->user()->role === 'admin')
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('jadwal.edit', $jadwal->id) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded">Edit</a>
                                                    <form action="{{ route('jadwal.destroy', $jadwal->id) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        @else
                                            <!-- Fitur KRS / Ambil Kelas Untuk Mahasiswa -->
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                @php
                                                    $sudahDiambil = auth()->user()->roster->contains($jadwal->id);
                                                @endphp

                                                @if ($sudahDiambil)
                                                    <span
                                                        class="bg-green-100 text-green-800 px-3 py-1 rounded-md text-xs font-bold shadow-sm border border-green-200">Terdaftar</span>
                                                @else
                                                    <form action="{{ route('jadwal.enroll', $jadwal->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded-md shadow-sm transition text-xs font-semibold">
                                                            + Ambil
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ auth()->user()->role === 'admin' ? 6 : 6 }}"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                            Belum ada jadwal yang ditambahkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
