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

    <div class="flex h-screen">

        @include('layouts.sidebar')

        <main class="flex-1 p-5 overflow-y-auto">

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
            <div class="grid grid-cols-4 gap-5 mb-6">

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
                <div class="col-span-3 grid grid-cols-3 gap-5">

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
            <div class="grid grid-cols-4 gap-5">

                <!-- CHART -->
                <div
                    class="col-span-3 bg-white rounded-3xl shadow-2xl border border-blue-100 p-6 h-96">

                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-slate-800">
                            Grafik Absensi Mingguan
                        </h2>

                        <span
                            class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                            Real-Time
                        </span>
                    </div>

                    <canvas id="absensiChart"></canvas>

                </div>

                <!-- SHORTCUT -->
                <div
                    class="bg-white rounded-3xl shadow-2xl border border-blue-100 p-5">

                    <h2 class="text-2xl font-bold mb-5 text-slate-800">
                        Jalan Pintas
                    </h2>

                    <div class="grid grid-cols-3 gap-4">

                        <div
                            class="bg-gradient-to-br from-blue-100 to-blue-200 h-24 rounded-2xl shadow-inner hover:scale-105 transition">
                        </div>

                        <div
                            class="bg-gradient-to-br from-indigo-100 to-indigo-200 h-24 rounded-2xl shadow-inner hover:scale-105 transition">
                        </div>

                        <div
                            class="bg-gradient-to-br from-cyan-100 to-cyan-200 h-24 rounded-2xl shadow-inner hover:scale-105 transition">
                        </div>

                        <div
                            class="bg-gradient-to-br from-sky-100 to-sky-200 h-24 rounded-2xl shadow-inner hover:scale-105 transition">
                        </div>

                        <div
                            class="bg-gradient-to-br from-blue-100 to-indigo-200 h-24 rounded-2xl shadow-inner hover:scale-105 transition">
                        </div>

                        <div
                            class="bg-gradient-to-br from-indigo-100 to-purple-200 h-24 rounded-2xl shadow-inner hover:scale-105 transition">
                        </div>

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
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                        label: 'ABSENSI 1',
                        data: [1, 3, 2, 1, 2, 1, 3],
                        backgroundColor: 'rgba(37, 99, 235, 0.8)',
                        borderRadius: 8
                    },
                    {
                        label: 'ABSENSI 2',
                        data: [1, 2, 1, 2, 1, 2, 1],
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderRadius: 8
                    },
                    {
                        label: 'ABSENSI 3',
                        data: [3, 1, 2, 1, 3, 2, 1],
                        backgroundColor: 'rgba(99, 102, 241, 0.7)',
                        borderRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#334155',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#475569'
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
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

    <!-- SIDEBAR -->
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