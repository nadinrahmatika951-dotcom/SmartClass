<x-app-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">
            Halo, {{ Auth::user()->name }} 👋
        </h2>
        <p class="text-gray-500 mt-1">Selamat datang di SmartClass Dashboard.</p>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-halus p-6 border-l-4 border-primary">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Mata Kuliah</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalMataKuliah }}</p>
                </div>
                <div class="p-3 bg-pinkbg rounded-full text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-halus p-6 border-l-4 border-primary">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Jadwal Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $jadwalHariIni }}</p>
                </div>
                <div class="p-3 bg-pinkbg rounded-full text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-halus p-6 border-l-4 border-primary">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Jumlah Dosen</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $jumlahDosen }}</p>
                </div>
                <div class="p-3 bg-pinkbg rounded-full text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        @if(Auth::user()->role === 'admin')
        <div class="bg-white rounded-xl shadow-halus p-6 border-l-4 border-primary">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Mahasiswa</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $jumlahUser }}</p>
                </div>
                <div class="p-3 bg-pinkbg rounded-full text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-xl shadow-halus p-6 mb-20 md:mb-0">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Jadwal per Hari</h3>
        <div class="relative h-72 w-full">
            <canvas id="jadwalChart"></canvas>
        </div>
    </div>

    <!-- Inisialisasi Chart.js -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('jadwalChart').getContext('2d');
            
            // Data dummy (nanti bisa dihubungkan via controller)
            const data = {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                datasets: [{
                    label: 'Jumlah Mata Kuliah',
                    data: [3, 2, 4, 1, 2],
                    backgroundColor: '#B24B4B',
                    borderRadius: 8,
                }]
            };

            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>