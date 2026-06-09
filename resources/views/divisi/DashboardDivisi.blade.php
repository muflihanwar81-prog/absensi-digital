<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CODIA-SYNC Dashboard</title>
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
    </style>
</head>

<body class="bg-slate-50 text-slate-900 font-sans selection:bg-blue-600 selection:text-white antialiased">

    <div class="flex min-h-screen">

        @include('layouts.partials.sidebar-divisi')

        <main class="flex-1 p-6 overflow-y-auto min-w-0 flex flex-col gap-6">

            <header class="bg-blue-600 to-blue-500 rounded-2xl shadow-sm border border-slate-200/80 p-4 flex justify-between items-center">
                <h1 class="text-l font-extrabold tracking-tight text-white leading-tight">KEPALA DIVISI</h1>
                <div class="text-right">
                    <p class="text-sm font-extrabold tracking-tight text-white leading-tight">Hallo, {{ $nama_user }}</p>
                </div>
            </header>

            <div class="bg-gradient-to-r from-blue-600 to-blue-500 rounded-2xl shadow-lg border border-blue-400 p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 hover:shadow-md transition-shadow duration-300">
                <div>
                    <p class="text-blue-100 font-semibold mb-2.5 uppercase tracking-wider text-xs">
                        Dashboard Kepala Divisi
                    </p>
                    <h2 class="text-4xl font-extrabold tracking-tight text-white leading-tight">
                        Selamat Datang di Divisi {{ $divisi }}
                    </h2>
                    <p class="mt-3 text-blue-100/90 text-base">
                        Pantau produktivitas tim, statistik kehadiran, dan riwayat absensi internal divisi Anda.
                    </p>
                </div>

                <div class="text-left md:text-right min-w-[200px]">
                    <div id="clock" class="text-6xl font-extrabold text-white tracking-tight drop-shadow-sm font-mono">
                        00 : 00 <span id="seconds" class="text-2xl align-top">00</span>
                    </div>
                    <div id="date" class="mt-3 text-blue-100 text-sm font-medium">Loading...</div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-6 w-full">

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                    <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">Total Karyawan</p>
                    <h1 class="text-5xl font-extrabold mt-3 text-blue-600 tracking-tight font-mono">
                        {{ $total_karyawan }}
                    </h1>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                    <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">Total Hadir</p>
                    <h1 class="text-5xl font-extrabold mt-3 text-emerald-600 tracking-tight font-mono">
                        {{ $hadir }}
                    </h1>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                    <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">Total Terlambat</p>
                    <h1 class="text-5xl font-extrabold mt-3 text-amber-500 tracking-tight font-mono">
                        {{ $terlambat }}
                    </h1>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                    <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">Total Alpha</p>
                    <h1 class="text-5xl font-extrabold mt-3 text-rose-500 tracking-tight font-mono">
                        {{ $alpha }}
                    </h1>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                    <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">Total Izin</p>
                    <h1 class="text-5xl font-extrabold mt-3 text-cyan-600 tracking-tight font-mono">
                        {{ $izin }}
                    </h1>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-200/80 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex flex-col justify-center">
                    <p class="font-semibold text-sm text-slate-500 uppercase tracking-wider">Total Sakit</p>
                    <h1 class="text-5xl font-extrabold mt-3 text-pink-500 tracking-tight font-mono">
                        {{ $sakit }}
                    </h1>
                </div>

            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow duration-300">
                <div class="flex flex-col xl:flex-row justify-between gap-8">
                    
                    {{-- PROFILE --}}
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center text-3xl font-black text-white shadow-lg">
                            {{ strtoupper(substr($nama_user, 0, 3)) }}
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.25em] text-blue-600 font-bold mb-1">Kepala Divisi</p>
                            <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $nama_user }}</h3>
                            <p class="text-lg text-slate-500 mt-1 font-semibold">Divisi {{ $divisi }}</p>
                        </div>
                    </div>

                    {{-- STATUS ABSENSI HARI INI --}}
                    <div class="text-left xl:text-right flex flex-col justify-center">
                        <p class="text-[10px] uppercase tracking-[0.25em] text-blue-600 font-bold mb-2">Status Hari Ini</p>
                        @if($absensiHariIni)
                            <div class="flex items-center xl:justify-end gap-4">
                                <div>
                                    <p class="text-sm text-slate-600 font-semibold">Masuk: <span class="text-green-600 font-black">{{ $absensiHariIni->jam_masuk ?? '-' }}</span></p>
                                    <p class="text-sm text-slate-600 font-semibold">Pulang: <span class="text-red-500 font-black">{{ $absensiHariIni->jam_keluar ?? '-' }}</span></p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-black
                                    @if($absensiHariIni->status == 'Hadir') bg-green-100 text-green-700
                                    @elseif($absensiHariIni->status == 'Terlambat') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    {{ $absensiHariIni->status }}
                                </span>
                            </div>
                        @else
                            <p class="text-sm text-slate-400 italic">Belum absen hari ini</p>
                        @endif
                    </div>
                </div>

                {{-- FLASH MESSAGES --}}
                @if(session('success'))
                    <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-semibold">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-semibold">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- ACTION BUTTONS --}}
                <div class="flex justify-end gap-4 mt-6">
                    @if(!$absensiHariIni)
                        <form action="{{ route('divisi.absensi.masuk') }}" method="POST" class="absensi-form">
                            @csrf
                            <button type="submit" class="w-44 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-black text-lg shadow-md hover:shadow-lg hover:scale-105 transition duration-300">
                                Masuk
                            </button>
                        </form>
                    @else
                        <button disabled class="w-44 bg-slate-100 text-slate-400 py-3 rounded-xl font-black text-lg cursor-not-allowed border border-slate-200">
                            ✓ Sudah Masuk
                        </button>
                    @endif

                    @if($absensiHariIni && !$absensiHariIni->jam_keluar)
                        <form action="{{ route('divisi.absensi.keluar') }}" method="POST" class="absensi-form">
                            @csrf
                            <button type="submit" class="w-44 bg-white border border-slate-300 text-slate-700 py-3 rounded-xl font-black text-lg shadow-md hover:bg-slate-50 hover:scale-105 transition duration-300">
                                Pulang
                            </button>
                        </form>
                    @elseif($absensiHariIni && $absensiHariIni->jam_keluar)
                        <button disabled class="w-44 bg-slate-100 text-slate-400 py-3 rounded-xl font-black text-lg cursor-not-allowed border border-slate-200">
                            ✓ Sudah Pulang
                        </button>
                    @else
                        <button disabled class="w-44 bg-slate-50 text-slate-300 py-3 rounded-xl font-black text-lg cursor-not-allowed border border-slate-100">
                            Pulang
                        </button>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 w-full">
                
                <div class="xl:col-span-3 bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 h-96 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-slate-800">Grafik Kehadiran Hari Ini</h2>
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200/60 px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Real-Time
                        </span>
                    </div>
                    <div class="h-72">
                        <canvas id="absensiChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition-shadow duration-300">
                    <div>
                        <h3 class="font-bold text-sm mb-4 text-slate-800 uppercase tracking-widest">Jalan Pintas</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('divisi.riwayat-absensi') }}" class="bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 p-4 rounded-xl font-bold text-xs h-24 flex items-center justify-center text-center text-slate-700 hover:text-blue-700 transition duration-200">
                                RIWAYAT<br>ABSENSI
                            </a>
                            <a href="{{ route('divisi.karyawan') }}" class="bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 p-4 rounded-xl font-bold text-xs h-24 flex items-center justify-center text-center text-slate-700 hover:text-blue-700 transition duration-200">
                                DATA<br>KARYAWAN
                            </a>
                            <a href="{{ route('divisi.data-perizinan') }}" class="col-span-2 bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 p-4 rounded-xl font-bold text-xs h-16 flex items-center justify-center text-slate-700 hover:text-blue-700 transition duration-200 uppercase tracking-wider">
                                Data Perizinan
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-800">
                        Riwayat Absensi Pribadi
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Jam Masuk</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Jam Pulang</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($aktivitas as $item)
                                <tr class="hover:bg-slate-50/80 transition duration-150">
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-700">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-emerald-600">{{ $item->jam_masuk ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-rose-500">{{ $item->jam_keluar ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-black
                                            @if($item->status == 'Hadir') bg-green-100 text-green-700
                                            @elseif($item->status == 'Terlambat') bg-yellow-100 text-yellow-700
                                            @elseif($item->status == 'Izin') bg-blue-100 text-blue-700
                                            @else bg-red-100 text-red-700
                                            @endif">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-slate-400 italic text-sm">
                                        Belum ada riwayat absensi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <script>
        const ctx = document.getElementById('absensiChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Hadir', 'Terlambat', 'Alpha', 'Izin', 'Sakit'],
                datasets: [{
                    label: 'Jumlah Data',
                    data: [
                        {{ max(0, $hadir - $terlambat) }},
                        {{ $terlambat }},
                        {{ $alpha }},
                        {{ $izin }},
                        {{ $sakit }}
                    ],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.85)', // Emerald
                        'rgba(245, 158, 11, 0.85)', // Amber
                        'rgba(239, 68, 68, 0.85)',  // Rose
                        'rgba(6, 182, 212, 0.85)',  // Cyan
                        'rgba(236, 72, 153, 0.85)'  // Pink
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
                    legend: { display: false }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#64748b',
                            font: { family: 'Plus Jakarta Sans', weight: '600', size: 11 }
                        },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#64748b',
                            font: { family: 'Plus Jakarta Sans', size: 11 }
                        },
                        grid: { color: 'rgba(226, 232, 240, 0.6)' }
                    }
                }
            }
        });
    </script>

    <script>
        function updateDateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            document.getElementById('clock').innerHTML = `${hours} : ${minutes} <span id="seconds" class="text-2xl align-top">${seconds}</span>`;

            const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            const tanggal = `${hari[now.getDay()]}, ${now.getDate()} ${bulan[now.getMonth()]} ${now.getFullYear()}`;
            document.getElementById('date').textContent = tanggal;
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.absensi-form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const button = form.querySelector('button[type="submit"]');
                    const originalText = button.innerHTML;
                    button.disabled = true;
                    button.innerHTML = '<span class="inline-block animate-spin mr-2">⏳</span>Mendapatkan GPS...';

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                const lat = position.coords.latitude;
                                const lng = position.coords.longitude;

                                let latInput = form.querySelector('input[name="latitude"]');
                                if (!latInput) {
                                    latInput = document.createElement('input');
                                    latInput.type = 'hidden';
                                    latInput.name = 'latitude';
                                    form.appendChild(latInput);
                                }
                                latInput.value = lat;

                                let lngInput = form.querySelector('input[name="longitude"]');
                                if (!lngInput) {
                                    lngInput = document.createElement('input');
                                    lngInput.type = 'hidden';
                                    lngInput.name = 'longitude';
                                    form.appendChild(lngInput);
                                }
                                lngInput.value = lng;

                                form.submit();
                            },
                            function(error) {
                                button.disabled = false;
                                button.innerHTML = originalText;
                                
                                let errorMessage = 'Gagal memverifikasi lokasi GPS. ';
                                switch(error.code) {
                                    case error.PERMISSION_DENIED:
                                        errorMessage += 'Mohon izinkan akses lokasi (GPS) pada browser Anda.';
                                        break;
                                    case error.POSITION_UNAVAILABLE:
                                        errorMessage += 'Informasi lokasi tidak tersedia.';
                                        break;
                                    case error.TIMEOUT:
                                        errorMessage += 'Waktu permintaan lokasi habis.';
                                        break;
                                    default:
                                        errorMessage += 'Terjadi kesalahan tidak dikenal.';
                                }
                                alert(errorMessage);
                            },
                            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                        );
                    } else {
                        button.disabled = false;
                        button.innerHTML = originalText;
                        alert('Browser Anda tidak mendukung deteksi lokasi GPS.');
                    }
                });
            });
        });
    </script>
</body>

</html>