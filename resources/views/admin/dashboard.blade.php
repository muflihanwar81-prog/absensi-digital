<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 font-sans selection:bg-blue-600 selection:text-white">

    <div class="flex min-h-screen">

        @include('layouts.sidebar')

        <main class="flex-1 p-6 overflow-y-auto min-w-0">

            <!-- HEADER -->
            @include('components.header_admin')

            <!-- WELCOME SECTION -->
            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-6 hover:shadow-md transition-shadow duration-300">

                <div>
                    <p class="text-blue-600 font-semibold mb-2.5 uppercase tracking-wider text-xs">
                        Dashboard Admin
                    </p>

                    <h2 class="text-4xl font-extrabold tracking-tight text-slate-800 leading-tight">
                        Selamat Datang di Manajemen<br />Kehadiran Karyawan
                    </h2>

                    <p class="mt-3 text-slate-500 text-base">
                        Pantau data absensi, divisi, dan kehadiran secara real-time.
                    </p>
                </div>

                <div class="text-left md:text-right min-w-[200px]">
                    <div id="clock"
                        class="text-6xl font-extrabold text-slate-850 tracking-tight drop-shadow-sm font-mono">
                    </div>

                    <div id="date" class="mt-3 text-slate-400 text-sm font-medium"></div>

                    <button
                        class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm shadow-blue-500/10 hover:shadow-blue-500/20 hover:scale-[1.02] transition-all duration-200">
                        Semua Divisi
                    </button>
                </div>
            </div>

            <!-- STATISTICS -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 mb-6 w-full">

                <!-- TOTAL DIVISI -->
                <div
                    class="bg-gradient-to-tr from-blue-600 to-indigo-600 text-white rounded-2xl shadow-sm flex flex-col justify-center items-center h-60 border border-blue-500/30 hover:scale-[1.01] transition-transform duration-200">
                    <p class="text-lg font-semibold mb-2 opacity-90">
                        Total Divisi
                    </p>
                    <h1 class="text-7xl font-extrabold tracking-tight drop-shadow-sm font-mono">
                        {{ $totalDivisi }}
                    </h1>
                </div>

                <!-- OTHER CARDS -->
                <div class="xl:col-span-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Karyawan
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-blue-650 tracking-tight font-mono">
                            {{ $totalKaryawan }}
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Hadir
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-emerald-600 tracking-tight font-mono">
                            {{ $totalHadir }}
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Terlambat
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-amber-500 tracking-tight font-mono">
                            {{ $totalTerlambat }}
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Alpha
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-rose-500 tracking-tight font-mono">
                            {{ $totalAlpha }}
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Izin
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-cyan-600 tracking-tight font-mono">
                            {{ $totalIzin }}
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Sakit
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-pink-500 tracking-tight font-mono">
                            {{ $totalSakit }}
                        </h1>
                    </div>

                </div>

            </div>

            <!-- CHART & SHORTCUT -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 w-full">

                <!-- CHART -->
                <div class="xl:col-span-3 bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 h-96">

                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-slate-800">
                            Grafik Kehadiran Hari Ini
                        </h2>

                        <span
                            class="bg-emerald-50 text-emerald-700 border border-emerald-200/60 px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Real-Time
                        </span>
                    </div>

                    <canvas id="absensiChart"></canvas>
                </div>
                <!-- AKTIFITAS ADMIN -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 min-w-0 flex flex-col h-[24rem]">

                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-slate-800">
                            Aktifitas Admin
                        </h2>
                        <a href="{{ route('admin.aktifitas') }}" class="text-blue-600 hover:text-blue-700 text-xs font-semibold">Lihat Semua</a>
                    </div>

                    <div class="flex-1 overflow-y-auto pr-2 space-y-4">
                        @php
                            $bgColors = [
                                'blue' => 'bg-blue-100',
                                'amber' => 'bg-amber-100',
                                'rose' => 'bg-rose-100',
                                'purple' => 'bg-purple-100',
                                'emerald' => 'bg-emerald-100',
                                'cyan' => 'bg-cyan-100',
                                'slate' => 'bg-slate-100',
                            ];
                            $textColors = [
                                'blue' => 'text-blue-600',
                                'amber' => 'text-amber-600',
                                'rose' => 'text-rose-600',
                                'purple' => 'text-purple-600',
                                'emerald' => 'text-emerald-600',
                                'cyan' => 'text-cyan-600',
                                'slate' => 'text-slate-600',
                            ];
                        @endphp

                        @forelse($activities as $activity)
                            @php
                                $bgColor = $bgColors[$activity->warna] ?? 'bg-slate-100';
                                $textColor = $textColors[$activity->warna] ?? 'text-slate-600';
                            @endphp
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-full {{ $bgColor }} flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-{{ $activity->icon }} {{ $textColor }} text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-700 leading-tight">{{ $activity->judul }}</p>
                                    @if($activity->deskripsi)
                                        <p class="text-xs text-slate-500 mt-1">{{ $activity->deskripsi }}</p>
                                    @endif
                                    <p class="text-[10px] text-slate-400 mt-1 font-mono">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-slate-400 text-sm">
                                <i class="fa-solid fa-clock-rotate-left text-2xl mb-2 block"></i>
                                Belum ada aktifitas hari ini.
                            </div>
                        @endforelse
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
                    {{ $totalHadir }},   // Hadir
                    {{ $totalTerlambat }},    // Terlambat
                    {{ $totalAlpha }},    // Alpha
                    {{ $totalIzin }},     // Izin
                    {{ $totalSakit }}      // Sakit
                ],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.85)',   // Emerald
                    'rgba(245, 158, 11, 0.85)',   // Amber
                    'rgba(239, 68, 68, 0.85)',    // Rose/Red
                    'rgba(6, 182, 212, 0.85)',    // Cyan
                    'rgba(236, 72, 153, 0.85)'    // Pink
                ],
                borderRadius: 8,
                borderWidth: 0,
                barThickness: 45
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
                        color: '#64748b',
                        font: {
                            family: 'Plus Jakarta Sans',
                            weight: '600',
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#64748b',
                        font: {
                            family: 'Plus Jakarta Sans',
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(226, 232, 240, 0.6)'
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
                `${hours}<span class="mx-1 opacity-70 animate-pulse">:</span>${minutes}<span class="text-2xl align-top opacity-50 font-medium">:${seconds}</span>`;

            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };

            const tanggal = now.toLocaleDateString('id-ID', options);

            document.getElementById('date').innerHTML = tanggal;
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>

</body>

</html>