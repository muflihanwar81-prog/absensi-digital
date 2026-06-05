<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

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


        /* Fade in + slide up for cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Slide in from left for welcome section */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Slide in from right for clock */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Scale up pulse for big number */
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }

            60% {
                transform: scale(1.05);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Glow effect after counter finishes */
        @keyframes glowPulse {

            0%,
            100% {
                text-shadow: 0 0 0px transparent;
            }

            50% {
                text-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            }
        }

        /* Chart section fade in */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Apply animations */
        .animate-welcome-left {
            animation: slideInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-welcome-right {
            animation: slideInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards;
            opacity: 0;
        }

        .animate-card {
            opacity: 0;
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-chart-section {
            opacity: 0;
            animation: fadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Counter glow after animation completes */
        .counter-done {
            animation: glowPulse 2s ease-in-out 1;
        }

        /* Stagger delays for cards */
        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        .delay-600 {
            animation-delay: 0.6s;
        }

        .delay-700 {
            animation-delay: 0.7s;
        }

        .delay-800 {
            animation-delay: 0.8s;
        }

        .delay-900 {
            animation-delay: 0.9s;
        }

        .delay-1000 {
            animation-delay: 1.0s;
        }

        /* Divisi Dropdown Styling */
        .divisi-select-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .divisi-select {
            appearance: none;
            -webkit-appearance: none;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            border: none;
            padding: 10px 40px 10px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(37, 99, 235, 0.1), 0 4px 12px rgba(37, 99, 235, 0.15);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            min-width: 180px;
        }

        .divisi-select:hover {
            background: linear-gradient(135deg, #1d4ed8, #4338ca);
            box-shadow: 0 1px 3px rgba(37, 99, 235, 0.15), 0 6px 16px rgba(37, 99, 235, 0.25);
            transform: scale(1.02);
        }

        .filter-icon {
            width: 24px;
            height: 24px;
            object-fit: contain;
            margin-right: 6px;
        }

        .divisi-select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3), 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .divisi-select option {
            background: #1e293b;
            color: white;
            padding: 8px;
        }

        .divisi-select-arrow {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: white;
            font-size: 11px;
            opacity: 0.9;
        }

        /* Loading shimmer for cards */
        @keyframes shimmer {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }

            100% {
                opacity: 1;
            }
        }

        .stats-loading .counter {
            animation: shimmer 0.8s ease-in-out infinite;
        }

        /* Divisi badge */
        .divisi-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.15);
            color: #2563eb;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
            transition: all 0.3s ease;
        }

        .divisi-badge.active {
            background: rgba(59, 130, 246, 0.12);
            border-color: rgba(59, 130, 246, 0.3);
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

                <div class="animate-welcome-left">
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

                <div class="text-left md:text-right min-w-[200px] animate-welcome-right">
                    <div id="clock"
                        class="text-6xl font-extrabold text-slate-850 tracking-tight drop-shadow-sm font-mono">
                    </div>

                    <div id="date" class="mt-3 text-slate-400 text-sm font-medium"></div>

                    <div class="divisi-select-wrapper mt-4">
                        <i class="fa-solid fa-filter text-blue-600 text-lg"></i>
                        <select id="divisiFilter" class="divisi-select">
                            <option value="">Semua Divisi</option>
                            @foreach($divisiList as $divisi)
                            <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                            @endforeach
                        </select>
                        <span class="divisi-select-arrow">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    <div id="divisiBadge" class="divisi-badge" style="display: none;">
                        <span class="filter-icon">
                            <i class="fa-solid fa-filter"></i>
                        </span>
                        <span id="divisiBadgeText">Semua Divisi</span>
                    </div>
                </div>
            </div>

            <!-- STATISTICS -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 mb-6 w-full">

                <!-- TOTAL DIVISI -->
                <div
                    class="bg-gradient-to-tr from-blue-600 to-indigo-600 text-white rounded-2xl shadow-sm flex flex-col justify-center items-center h-60 border border-blue-500/30 hover:scale-[1.01] transition-transform duration-200 animate-card delay-200">
                    <p class="text-lg font-semibold mb-2 opacity-90">
                        Total Divisi
                    </p>
                    <h1 class="text-7xl font-extrabold tracking-tight drop-shadow-sm font-mono animate-scale-in">
                        <span class="counter" data-target="{{ $totalDivisi }}">0</span>
                    </h1>
                </div>

                <!-- OTHER CARDS -->
                <div class="xl:col-span-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center animate-card delay-300">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Karyawan
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-blue-650 tracking-tight font-mono">
                            <span class="counter" data-target="{{ $totalKaryawan }}" data-key="totalKaryawan">0</span>
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center animate-card delay-400">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Hadir
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-emerald-600 tracking-tight font-mono">
                            <span class="counter" data-target="{{ $totalHadir }}" data-key="totalHadir">0</span>
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center animate-card delay-500">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Terlambat
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-amber-500 tracking-tight font-mono">
                            <span class="counter" data-target="{{ $totalTerlambat }}" data-key="totalTerlambat">0</span>
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center animate-card delay-600">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Alpha
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-rose-500 tracking-tight font-mono">
                            <span class="counter" data-target="{{ $totalAlpha }}" data-key="totalAlpha">0</span>
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center animate-card delay-700">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Izin
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-cyan-600 tracking-tight font-mono">
                            <span class="counter" data-target="{{ $totalIzin }}" data-key="totalIzin">0</span>
                        </h1>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center animate-card delay-800">
                        <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">
                            Total Sakit
                        </p>
                        <h1 class="text-5xl font-extrabold mt-3 text-pink-500 tracking-tight font-mono">
                            <span class="counter" data-target="{{ $totalSakit }}" data-key="totalSakit">0</span>
                        </h1>
                    </div>

                </div>

            </div>

            <!-- CHART & SHORTCUT -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 w-full">

                <!-- CHART -->
                <div class="xl:col-span-3 bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 h-96 animate-chart-section delay-900">

                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-slate-800">
                            Grafik Kehadiran Hari Ini
                        </h2>
                    </div>

                    <canvas id="absensiChart"></canvas>
                </div>
                <!-- AKTIFITAS ADMIN -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 min-w-0 flex flex-col h-[24rem] animate-chart-section delay-1000">

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

    <!-- CHART with animation -->
    <script>
        const ctx = document.getElementById('absensiChart');

        let absensiChart = new Chart(ctx, {
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
                    data: [{
                            $totalHadir
                        },
                        {
                            $totalTerlambat
                        },
                        {
                            $totalAlpha
                        },
                        {
                            $totalIzin
                        },
                        {
                            $totalSakit
                        }
                    ],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.85)', // Emerald
                        'rgba(245, 158, 11, 0.85)', // Amber
                        'rgba(239, 68, 68, 0.85)', // Rose/Red
                        'rgba(6, 182, 212, 0.85)', // Cyan
                        'rgba(236, 72, 153, 0.85)' // Pink
                    ],
                    borderRadius: 8,
                    borderWidth: 0,
                    barThickness: 45
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart',
                    delay: function(context) {
                        // Stagger each bar animation
                        return context.dataIndex * 200 + 800;
                    }
                },
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

    <!-- COUNTER ANIMATION -->
    <script>
        /**
         * Animasi counter: angka naik dari 0 ke target
         * Menggunakan easeOutExpo untuk efek smooth deceleration
         */
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');

            counters.forEach((counter, index) => {
                const target = parseInt(counter.getAttribute('data-target')) || 0;
                const duration = 2000;
                const startDelay = index * 10;

                if (target === 0) {
                    counter.textContent = '0';
                    return;
                }

                setTimeout(() => {
                    let startTime = null;

                    function easeOutExpo(t) {
                        return t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
                    }

                    function updateCounter(currentTime) {
                        if (!startTime) startTime = currentTime;
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);

                        // Apply easing
                        const easedProgress = easeOutExpo(progress);
                        const currentValue = Math.floor(easedProgress * target);

                        counter.textContent = currentValue.toLocaleString('id-ID');

                        if (progress < 1) {
                            requestAnimationFrame(updateCounter);
                        } else {
                            // Final value & glow effect
                            counter.textContent = target.toLocaleString('id-ID');
                            counter.classList.add('counter-done');
                        }
                    }

                    requestAnimationFrame(updateCounter);
                }, startDelay);
            });
        }

        // Trigger counters when page loads
        document.addEventListener('DOMContentLoaded', () => {
            // Small delay agar card animation selesai dulu
            setTimeout(animateCounters, 400);
        });
    </script>

    <!-- DIVISI FILTER AJAX -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const divisiSelect = document.getElementById('divisiFilter');
            const divisiBadge = document.getElementById('divisiBadge');
            const divisiBadgeText = document.getElementById('divisiBadgeText');
            const statsContainer = document.querySelector('.grid.grid-cols-1.xl\\:grid-cols-4');

            divisiSelect.addEventListener('change', async function() {
                const divisiId = this.value;
                const selectedText = this.options[this.selectedIndex].text;

                // Show loading state
                if (statsContainer) {
                    statsContainer.classList.add('stats-loading');
                }

                // Update badge
                if (divisiId) {
                    divisiBadge.style.display = 'inline-flex';
                    divisiBadge.classList.add('active');
                    divisiBadgeText.textContent = 'Filter: ' + selectedText;
                } else {
                    divisiBadge.style.display = 'none';
                    divisiBadge.classList.remove('active');
                }

                try {
                    // Fetch filtered stats
                    const url = divisiId ?
                        `/dashboard/stats?divisi_id=${divisiId}` :
                        `/dashboard/stats`;

                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (!response.ok) throw new Error('Network error');

                    const data = await response.json();

                    // Update counter targets and re-animate
                    const counterMap = {
                        'totalKaryawan': data.totalKaryawan,
                        'totalHadir': data.totalHadir,
                        'totalTerlambat': data.totalTerlambat,
                        'totalAlpha': data.totalAlpha,
                        'totalIzin': data.totalIzin,
                        'totalSakit': data.totalSakit,
                    };

                    // Animate each counter to new value
                    Object.entries(counterMap).forEach(([key, newTarget], index) => {
                        const counter = document.querySelector(`.counter[data-key="${key}"]`);
                        if (!counter) return;

                        const currentValue = parseInt(counter.textContent.replace(/\./g, '')) || 0;
                        counter.setAttribute('data-target', newTarget);
                        counter.classList.remove('counter-done');

                        // Animate from current value to new value
                        animateSingleCounter(counter, currentValue, newTarget, index * 80);
                    });

                    // Update chart with animation
                    updateChart(data);

                } catch (error) {
                    console.error('Error fetching stats:', error);
                } finally {
                    // Remove loading state
                    if (statsContainer) {
                        statsContainer.classList.remove('stats-loading');
                    }
                }
            });
        });

        /**
         * Animate a single counter from oldValue to newValue
         */
        function animateSingleCounter(counter, fromValue, toValue, delay = 0) {
            const duration = 1200;

            setTimeout(() => {
                let startTime = null;

                function easeOutExpo(t) {
                    return t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
                }

                function step(currentTime) {
                    if (!startTime) startTime = currentTime;
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const easedProgress = easeOutExpo(progress);

                    const currentValue = Math.floor(fromValue + (toValue - fromValue) * easedProgress);
                    counter.textContent = currentValue.toLocaleString('id-ID');

                    if (progress < 1) {
                        requestAnimationFrame(step);
                    } else {
                        counter.textContent = toValue.toLocaleString('id-ID');
                        counter.classList.add('counter-done');
                    }
                }

                requestAnimationFrame(step);
            }, delay);
        }

        /**
         * Update chart data with smooth animation
         */
        function updateChart(data) {
            if (typeof absensiChart === 'undefined') return;

            // Update data
            absensiChart.data.datasets[0].data = [
                data.totalHadir,
                data.totalTerlambat,
                data.totalAlpha,
                data.totalIzin,
                data.totalSakit
            ];

            // Re-animate chart
            absensiChart.options.animation = {
                duration: 800,
                easing: 'easeOutQuart',
                delay: function(context) {
                    return context.dataIndex * 100;
                }
            };

            absensiChart.update();
        }
    </script>

</body>

</html>