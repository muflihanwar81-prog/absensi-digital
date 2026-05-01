<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white border-b shadow-sm px-6 py-3 flex justify-between items-center">
    <h1 class="text-xl font-bold text-gray-800">Absensi Digital</h1>
    
    <button id="dropdownButton" data-dropdown-toggle="dropdown" class="flex items-center gap-2 text-sm bg-gray-200 px-3 py-2 rounded-lg">
        Admin
    </button>

    <div id="dropdown" class="hidden bg-white rounded-lg shadow w-40">
        <ul class="py-2 text-sm text-gray-700">
            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a></li>
            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="flex">

    <aside class="w-64 h-screen bg-white shadow-md p-5">
        <ul class="space-y-4">
            <li>
                <a href="/dashboard" class="flex items-center p-2 rounded-lg bg-blue-100 text-blue-600">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/karyawan" class="flex items-center p-2 rounded-lg hover:bg-gray-200">
                    Data Karyawan
                </a>
            </li>
            <li>
                <a href="/absensi" class="flex items-center p-2 rounded-lg hover:bg-gray-200">
                    Absensi
                </a>
            </li>
            <li>
                <a href="/laporan" class="flex items-center p-2 rounded-lg hover:bg-gray-200">
                    Laporan
                </a>
            </li>
        </ul>
    </aside>

    <main class="flex-1 p-6">

        <h2 class="text-2xl font-semibold mb-6">Dashboard</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-gray-500">Hadir</h3>
                <p class="text-3xl font-bold text-green-500">20</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-gray-500">Izin</h3>
                <p class="text-3xl font-bold text-yellow-500">5</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-gray-500">Alfa</h3>
                <p class="text-3xl font-bold text-red-500">2</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow mb-8">
            <h3 class="text-lg font-semibold mb-4">Statistik Kehadiran Minggu Ini</h3>
            <div class="h-64">
                <canvas id="absensiChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="text-lg font-semibold mb-4">Data Absensi Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Divisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="px-6 py-4">Budi</td>
                            <td class="px-6 py-4">2026-04-17</td>
                            <td class="px-6 py-4 text-green-500">Hadir</td>
                            <td class="px-6 py-4">IT</td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-6 py-4">Siti</td>
                            <td class="px-6 py-4">2026-04-17</td>
                            <td class="px-6 py-4 text-yellow-500">Izin</td>
                            <td class="px-6 py-4">HR</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<script>
    const ctx = document.getElementById('absensiChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar', // Bisa diganti 'line' atau 'pie'
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            datasets: [{
                label: 'Jumlah Karyawan Hadir',
                data: [18, 19, 20, 17, 20, 15],
                backgroundColor: 'rgba(59, 130, 246, 0.5)', // Warna biru Tailwind
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>