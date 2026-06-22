{{-- resources/views/karyawan/dashboard.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan Dashboard - CODIA SYNC</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 font-sans selection:bg-blue-600 selection:text-white">

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        @include('layouts.sidebar_karyawan')

        {{-- MAIN CONTENT --}}
        <main id="mainContent"
        class="ml-72 flex-1 transition-all duration-300">

            {{-- TOP HEADER --}}
            @include('components.header')

            {{-- CONTENT --}}
            <div class="p-6">

                {{-- WELCOME CARD --}}
                <div
                    class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-8 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 hover:shadow-md transition-shadow duration-300">
                    <div>
                        <p class="text-blue-600 font-semibold mb-2.5 uppercase tracking-wider text-xs">
                            selamat datang kembali
                        </p>

                        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                            Selamat Datang Karyawan
                        </h2>

                        <p class="text-slate-500 text-sm mt-1.5">
                            Dashboard presensi dan aktivitas harian Anda.
                        </p>
                    </div>

                    <div
                        class="px-5 py-3.5 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white shadow-sm shadow-blue-500/10">
                        <p class="text-xxs uppercase tracking-wider opacity-85">
                            Divisi
                        </p>
                        <p class="text-lg font-bold mt-0.5">
                            {{ auth()->user()->divisi ?? 'Divisi' }}
                        </p>
                    </div>
                </div>

                {{-- STATISTICS --}}
                <div class="grid grid-cols-2 xl:grid-cols-4 gap-6 mb-6">

                    {{-- HADIR --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-between hover:shadow-md hover:scale-[1.01] transition-all duration-200 text-center">
                        <p class="text-xxs uppercase tracking-wider text-slate-400 font-bold mb-2">
                            Hadir
                        </p>
                        <p class="text-5xl font-extrabold text-emerald-600 tracking-tight font-mono">
                            {{ $hadir ?? 0 }}
                        </p>
                    </div>

                    {{-- TERLAMBAT --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-between hover:shadow-md hover:scale-[1.01] transition-all duration-200 text-center">
                        <p class="text-xxs uppercase tracking-wider text-slate-400 font-bold mb-2">
                            Terlambat
                        </p>
                        <p class="text-5xl font-extrabold text-amber-500 tracking-tight font-mono">
                            {{ $terlambat ?? 0 }}
                        </p>
                    </div>

                    {{-- TIDAK HADIR --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-between hover:shadow-md hover:scale-[1.01] transition-all duration-200 text-center">
                        <p class="text-xxs uppercase tracking-wider text-slate-400 font-bold mb-2">
                            Tidak Hadir
                        </p>
                        <p class="text-5xl font-extrabold text-rose-500 tracking-tight font-mono">
                            {{ $tidakHadir ?? 0 }}
                        </p>
                    </div>

                    {{-- IZIN --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-between hover:shadow-md hover:scale-[1.01] transition-all duration-200 text-center">
                        <p class="text-xxs uppercase tracking-wider text-slate-400 font-bold mb-2">
                            Izin
                        </p>
                        <p class="text-5xl font-extrabold text-blue-600 tracking-tight font-mono">
                            {{ $izin ?? 0 }}
                        </p>
                    </div>

                </div>

                {{-- PROFILE + CLOCK CARD --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-8 mb-6">

                    <div class="flex flex-col xl:flex-row justify-between gap-8">

                        {{-- PROFILE --}}
                        <div class="flex items-center gap-5">
                            <div
                                class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-blue-50 to-indigo-600 flex items-center justify-center text-2xl font-extrabold text-white shadow-md ring-2 ring-white/10 shrink-0">
                                {{ strtoupper(substr(auth()->user()->nama ?? 'Karyawan', 0, 3)) }}
                            </div>

                            <div>
                                <p class="text-xxs uppercase tracking-wider text-slate-400 font-bold mb-1">
                                    Karyawan Profil
                                </p>

                                <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                                    {{ auth()->user()->nama ?? 'Karyawan' }}
                                </h3>

                                <p class="text-base text-slate-500 mt-1 font-medium">
                                    {{ auth()->user()->jabatan ?? 'Karyawan' }}
                                </p>
                            </div>
                        </div>

                        {{-- CLOCK --}}
                        <div class="text-left xl:text-right">
                            <p class="text-xxs uppercase tracking-wider text-blue-600 font-bold mb-1">
                                Waktu Sekarang
                            </p>

                            <div id="clock"
                                class="text-5xl font-extrabold text-slate-850 leading-none tracking-tight font-mono">
                                00 : 00
                            </div>

                            <div id="date"
                                class="text-sm text-slate-400 mt-2 font-semibold">
                                -
                            </div>
                        </div>

                    </div>

                    {{-- ACTION BUTTONS --}}
                    {{-- FLASH MESSAGES --}}
                    @if(session('success'))
                        <div class="mt-6 p-4 bg-emerald-50 border border-emerald-250 rounded-xl text-emerald-700 text-sm font-semibold shadow-sm flex items-center gap-2">
                            <span>✅</span> <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mt-6 p-4 bg-rose-50 border border-rose-250 rounded-xl text-rose-700 text-sm font-semibold shadow-sm flex items-center gap-2">
                            <span>❌</span> <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-end gap-4 mt-8 flex-wrap">

                        {{-- Tombol Masuk --}}
                        <form action="{{ route('karyawan.absensi.masuk') }}" method="POST" class="absensi-form">
                            @csrf
                            <button type="submit"
                                class="w-48 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold text-sm shadow-sm shadow-blue-500/10 hover:scale-[1.02] transition-all">
                                Masuk
                            </button>
                        </form>

                        {{-- Tombol Pulang --}}
                        <form action="{{ route('karyawan.absensi.pulang') }}" method="POST" class="absensi-form">
                            @csrf
                            <button type="submit"
                                class="w-48 bg-white border border-slate-200 text-slate-700 py-3 rounded-xl font-semibold text-sm shadow-sm hover:bg-slate-50 transition-all">
                                Pulang
                            </button>
                        </form>

                    </div>

                </div>

                {{-- ACTIVITY SECTION --}}
                <div>
                    <div class="mb-4">
                        <p class="text-blue-600 font-semibold uppercase tracking-wider text-xs mb-1">
                            Daily Activity
                        </p>
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">
                            Aktivitas Hari Ini
                        </h3>
                    </div>

                    {{-- TABLE CARD --}}
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-6">

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">

                                {{-- TABLE HEADER --}}
                                <thead
                                    class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                                    <tr>
                                        <th class="px-6 py-3.5 text-left font-semibold">No</th>
                                        <th class="px-6 py-3.5 text-left font-semibold">Nama Karyawan</th>
                                        <th class="px-6 py-3.5 text-left font-semibold">Tanggal</th>
                                        <th class="px-6 py-3.5 text-left font-semibold">jam masuk</th>
                                        <th class="px-6 py-3.5 text-left font-semibold">jam pulang</th>
                                        <th class="px-6 py-3.5 text-left font-semibold">Keterangan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                    $aktivitas = $aktivitas ?? collect();
                                    @endphp

                                    @forelse($aktivitas as $item)
                                    <tr
                                        class="border-t border-slate-100 hover:bg-slate-50/70 text-slate-700 text-sm transition duration-150">

                                        {{-- NO --}}
                                        <td class="px-6 py-4 font-mono font-medium text-slate-500">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- NAMA --}}
                                        <td class="px-6 py-4 font-bold text-slate-800">
                                            {{ auth()->user()->nama }}
                                        </td>

                                        {{-- TANGGAL --}}
                                        <td class="px-6 py-4 font-mono text-slate-600 text-xs">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                        </td>

                                        {{-- JAM MASUK --}}
                                        <td class="px-6 py-4 font-semibold text-emerald-600 font-mono">
                                            {{ $item->jam_masuk ?? '-' }}
                                        </td>

                                        {{-- JAM PULANG --}}
                                        <td class="px-6 py-4 font-semibold text-rose-500 font-mono">
                                            {{ $item->jam_keluar ?? '-' }}
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                                    @if(($item->status ?? '-') == 'Hadir')
                                                        bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20
                                                    @elseif(($item->status ?? '-') == 'Terlambat')
                                                        bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20
                                                    @elseif(($item->status ?? '-') == 'Izin')
                                                        bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20
                                                    @else
                                                        bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20
                                                    @endif">

                                                {{ $item->status ?? '-' }}

                                            </span>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6"
                                            class="py-16 text-center text-slate-400 italic text-sm">
                                            Belum ada aktivitas hari ini.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>

            </div>

        </main>

    </div>

    {{-- CLOCK SCRIPT --}}
    <script>
        function updateClock() {
            const now = new Date();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            document.getElementById('clock').textContent = `${hours} : ${minutes}`;

            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };

            document.getElementById('date').textContent =
                now.toLocaleDateString('id-ID', options);
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>

    {{-- GPS GEOLOCATION SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.absensi-form');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const button = form.querySelector('button[type="submit"]');
                    const originalText = button.innerHTML;
                    button.disabled = true;
                    button.innerHTML = '<span class="inline-block animate-spin mr-2">⏳</span>GPS...';

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                const lat = position.coords.latitude;
                                const lng = position.coords.longitude;

                                // Buat input tersembunyi
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

                                // Submit form asli
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
                            {
                                enableHighAccuracy: true,
                                timeout: 10000,
                                maximumAge: 0
                            }
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