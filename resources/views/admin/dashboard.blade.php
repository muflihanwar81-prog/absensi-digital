<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-200 font-sans">

<div class="flex h-screen">

@include('layouts.partials.sidebar')

    <main class="flex-1 p-5 overflow-y-auto">

        <div class="bg-gray-300 px-6 py-4 flex justify-between items-center mb-5">
            <h1 class="text-3xl font-bold">
                CODIA-SYNC
            </h1>

            <div class="font-semibold">
                Hallo, Dio Kurniawan
            </div>
        </div>

        <div class="bg-gray-300 rounded-lg p-6 flex justify-between items-start mb-6">

            <div>
                <h2 class="text-5xl font-bold leading-tight">
                    Selamat Datang di Manajemen <br>
                    Kehadiran Karyawan
                </h2>
            </div>

            <div class="text-right">
                <div class="text-7xl font-bold">
                    08<span class="mx-2">:</span>57<span class="text-3xl">25</span>
                </div>

                <div class="mt-6 text-gray-600">
                    Tanggal 2 Nov 2026
                </div>

                <button class="mt-3 bg-gray-200 px-4 py-2 rounded-lg font-semibold">
                    Semua Divisi
                </button>
            </div>

        </div>

        <div class="grid grid-cols-4 gap-5 mb-6">

            <div class="bg-gray-300 rounded-lg flex flex-col justify-center items-center h-60">
                <p class="text-xl font-semibold mb-3">Total Divisi</p>
                <h1 class="text-8xl font-bold">6</h1>
            </div>

            <div class="col-span-3 grid grid-cols-3 gap-5">

                <div class="bg-gray-300 rounded-lg p-5 text-center">
                    <p class="font-semibold text-xl">Total Karyawan</p>
                    <h1 class="text-6xl font-bold mt-2">300</h1>
                </div>

                <div class="bg-gray-300 rounded-lg p-5 text-center">
                    <p class="font-semibold text-xl">Total Hadir</p>
                    <h1 class="text-6xl font-bold mt-2">260</h1>
                </div>

                <div class="bg-gray-300 rounded-lg p-5 text-center">
                    <p class="font-semibold text-xl">Total Terlambat</p>
                    <h1 class="text-6xl font-bold mt-2">10</h1>
                </div>

                <div class="bg-gray-300 rounded-lg p-5 text-center">
                    <p class="font-semibold text-xl">Total Alpha</p>
                    <h1 class="text-6xl font-bold mt-2">20</h1>
                </div>

                <div class="bg-gray-300 rounded-lg p-5 text-center">
                    <p class="font-semibold text-xl">Total Izin</p>
                    <h1 class="text-6xl font-bold mt-2">5</h1>
                </div>

                <div class="bg-gray-300 rounded-lg p-5 text-center">
                    <p class="font-semibold text-xl">Total Sakit</p>
                    <h1 class="text-6xl font-bold mt-2">5</h1>
                </div>

            </div>

        </div>

        <div class="grid grid-cols-4 gap-5">

            <div class="col-span-3 bg-gray-300 rounded-lg p-5 h-96">

                <canvas id="absensiChart"></canvas>

            </div>

            <div class="bg-gray-300 rounded-lg p-5">

                <h2 class="text-2xl font-bold mb-5">
                    Jalan Pintas:
                </h2>

                <div class="grid grid-cols-3 gap-4">

                    <div class="bg-gray-100 h-24 rounded-lg"></div>
                    <div class="bg-gray-100 h-24 rounded-lg"></div>
                    <div class="bg-gray-100 h-24 rounded-lg"></div>

                    <div class="bg-gray-100 h-24 rounded-lg"></div>
                    <div class="bg-gray-100 h-24 rounded-lg"></div>
                    <div class="bg-gray-100 h-24 rounded-lg"></div>

                </div>

            </div>

        </div>

    </main>

</div>

<script>
const ctx = document.getElementById('absensiChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            'Sen',
            'Sel',
            'Rab',
            'Kam',
            'Jum',
            'Sab',
            'Min'
        ],
        datasets: [
            {
                label: 'ABSENSI 1',
                data: [1,3,2,1,2,1,3],
            },
            {
                label: 'ABSENSI 2',
                data: [1,2,1,2,1,2,1],
            },
            {
                label: 'ABSENSI 3',
                data: [3,1,2,1,3,2,1],
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>
<script>
function toggleSidebar() {

    const sidebar = document.getElementById('sidebar');
    const texts = document.querySelectorAll('.menu-text');
    const title = document.getElementById('sidebarTitle');

    sidebar.classList.toggle('w-64');
    sidebar.classList.toggle('w-24');

    texts.forEach(text => {
        text.classList.toggle('hidden');
    });

    title.classList.toggle('hidden');
}
</script>

</body>
</html>