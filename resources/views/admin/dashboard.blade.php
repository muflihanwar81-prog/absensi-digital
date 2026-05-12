<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 font-sans">

    <div class="flex min-h-screen">

        @include('layouts.sidebar')

        <main class="flex-1 p-5 overflow-y-auto min-w-0">

            <!-- HEADER -->
            @include('components.header_admin')

            <!-- WELCOME SECTION -->
            <div
                class="bg-white rounded-3xl shadow-2xl border border-blue-100 p-8 flex justify-between items-start mb-6">

                <div>
                    <p class="text-blue-600 font-semibold mb-3 uppercase tracking-widest text-sm">
                        Dashboard Admin
                    </p>

                    <h2 class="text-5xl font-extrabold leading-tight text-slate-800">
                        Selamat Datang di Manajemen <br />
                        Kehadiran Karyawan
                    </h2>

                    <p class="mt-4 text-slate-500 text-lg">
                        Pantau data absensi, divisi, dan kehadiran secara real-time.
                    </p>
                </div>

                <div class="text-right">
                    <div id="clock"
                        class="text-7xl font-extrabold text-blue-700 tracking-tight drop-shadow-sm">
                    </div>

                    <div id="date" class="mt-6 text-slate-500 font-medium"></div>

                    <button
                        class="mt-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition duration-300">
                        Semua Divisi
                    </button>
                </div>
            </div>

            <!-- STATISTICS -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 mb-6 w-full">

                <!-- TOTAL DIVISI -->
                <div
                    class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-3xl shadow-2xl flex flex-col justify-center items-center h-60 border border-blue-400/30">
                    <p class="text-xl font-semibold mb-3 opacity-90">
                        Total Divisi
                    </p>
                    <h1 class="text-8xl font-extrabold drop-shadow-md">
                        {{ $totalDivisi }}
                    </h1>
                </div>

                <!-- OTHER CARDS -->
                <div class="xl:col-span-3 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 w-full">

                    <div
                        class="bg-white rounded-2xl p-5 text-center shadow-lg border border-blue-100 hover:shadow-xl transition">
                        <p class="font-semibold text-xl text-slate-600">
                            Total Karyawan
                        </p>
                        <h1 class="text-6xl font-extrabold mt-2 text-blue-700">
                            300
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-5 text-center shadow-lg border border-green-100 hover:shadow-xl transition">
                        <p class="font-semibold text-xl text-slate-600">
                            Total Hadir
                        </p>
                        <h1 class="text-6xl font-extrabold mt-2 text-green-600">
                            260
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-5 text-center shadow-lg border border-yellow-100 hover:shadow-xl transition">
                        <p class="font-semibold text-xl text-slate-600">
                            Total Terlambat
                        </p>
                        <h1 class="text-6xl font-extrabold mt-2 text-yellow-500">
                            10
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-5 text-center shadow-lg border border-red-100 hover:shadow-xl transition">
                        <p class="font-semibold text-xl text-slate-600">
                            Total Alpha
                        </p>
                        <h1 class="text-6xl font-extrabold mt-2 text-red-500">
                            20
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-5 text-center shadow-lg border border-cyan-100 hover:shadow-xl transition">
                        <p class="font-semibold text-xl text-slate-600">
                            Total Izin
                        </p>
                        <h1 class="text-6xl font-extrabold mt-2 text-cyan-600">
                            5
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-5 text-center shadow-lg border border-pink-100 hover:shadow-xl transition">
                        <p class="font-semibold text-xl text-slate-600">
                            Total Sakit
                        </p>
                        <h1 class="text-6xl font-extrabold mt-2 text-pink-600">
                            5
                        </h1>
                    </div>

                </div>

            </div>

            <!-- CHART & SHORTCUT -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 w-full">

    <!-- CHART -->
    <div class="xl:col-span-3 bg-white rounded-3xl shadow-2xl border border-blue-100 p-6 h-96">

        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-slate-800">
                Grafik Statistik Kehadiran
            </h2>

            <span
                class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                Real-Time
            </span>
        </div>

        <canvas id="absensiChart"></canvas>
    </div>

    <!-- SHORTCUT -->
    <div class="bg-white rounded-3xl shadow-2xl border border-blue-100 p-5 min-w-0">

        <h2 class="text-2xl font-bold mb-5 text-slate-800">
            Jalan Pintas
        </h2>

        <div class="grid grid-cols-2 gap-4">

            <!-- Kelola Divisi -->
            <a href="{{ route('admin.keloladivisi') }}"
               class="bg-gradient-to-br from-blue-100 to-blue-200 h-24 rounded-2xl shadow-inner hover:scale-105 transition flex flex-col items-center justify-center text-blue-800 font-bold text-sm">
                🏢
                <span class="mt-1 text-center">Kelola Divisi</span>
            </a>

            <!-- Data Karyawan -->
            <a href="{{ route('admin.karyawan') }}"
               class="bg-gradient-to-br from-indigo-100 to-indigo-200 h-24 rounded-2xl shadow-inner hover:scale-105 transition flex flex-col items-center justify-center text-indigo-800 font-bold text-sm">
                👨‍💼
                <span class="mt-1 text-center">Data Karyawan</span>
            </a>

            <!-- Data Kehadiran -->
            <a href="{{ route('admin.absensi.index') }}"
               class="bg-gradient-to-br from-green-100 to-green-200 h-24 rounded-2xl shadow-inner hover:scale-105 transition flex flex-col items-center justify-center text-green-800 font-bold text-sm">
                📅
                <span class="mt-1 text-center">Data Kehadiran</span>
            </a>

            <!-- Data Perizinan -->
            <a href="{{ route('admin.perizinan.index') }}"
               class="bg-gradient-to-br from-yellow-100 to-yellow-200 h-24 rounded-2xl shadow-inner hover:scale-105 transition flex flex-col items-center justify-center text-yellow-800 font-bold text-sm">
                📄
                <span class="mt-1 text-center">Perizinan</span>
            </a>

            <!-- Laporan -->
            <a href="{{ route('admin.laporan') }}"
               class="bg-gradient-to-br from-purple-100 to-purple-200 h-24 rounded-2xl shadow-inner hover:scale-105 transition flex flex-col items-center justify-center text-purple-800 font-bold text-sm col-span-2">
                📊
                <span class="mt-1 text-center">Laporan</span>
            </a>

        </div>
    </div>

</div>
        </main>

    </div>

    <!-- CHART -->
    <script>
    const ctx = document.getElementById('absensiChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [

                'Hadir',
                'Terlambat',
                'Alpha',
                'Izin',
                'Sakit'
            ],
            datasets: [{
                label: 'Jumlah Data',
                data: [
                    260,   // Hadir
                    10,    // Terlambat
                    20,    // Alpha
                    5,     // Izin
                    5      // Sakit
                ],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',   // Hijau
                    'rgba(234, 179, 8, 0.8)',   // Kuning
                    'rgba(239, 68, 68, 0.8)',   // Merah
                    'rgba(6, 182, 212, 0.8)',   // Cyan
                    'rgba(236, 72, 153, 0.8)'   // Pink
                ],
                borderRadius: 10,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#475569',
                        font: {
                            weight: 'bold'
                        }
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#475569'
                    },
                    grid: {
                        color: 'rgba(148, 163, 184, 0.15)'
                    }
                }
            }
        }
    });
</script>

    <!-- CLOCK -->
    <script>
        function updateClock() {
            const now = new Date();

            let hours = String(now.getHours()).padStart(2, '0');
            let minutes = String(now.getMinutes()).padStart(2, '0');
            let seconds = String(now.getSeconds()).padStart(2, '0');

            document.getElementById('clock').innerHTML =
                `${hours}<span class="mx-2">:</span>${minutes}<span class="text-3xl align-top">:${seconds}</span>`;

            const options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };

            const tanggal = now.toLocaleDateString('id-ID', options);

            document.getElementById('date').innerHTML =
                `Tanggal ${tanggal}`;
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>

</body>

</html>