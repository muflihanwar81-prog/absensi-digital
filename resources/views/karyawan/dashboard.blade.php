{{-- resources/views/karyawan/dashboard.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan Dashboard - CODIA SYNC</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 font-sans">

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        @include('layouts.sidebar_karyawan')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto">

            {{-- TOP HEADER --}}
            @include('components.header')

            {{-- CONTENT --}}
            <div class="p-6">

                {{-- WELCOME CARD --}}
                <div
                    class="bg-white rounded-3xl shadow-2xl border border-blue-100 p-8 mb-6 flex justify-between items-center">
                    <div>
                        <p class="text-sm uppercase tracking-[0.25em] text-blue-600 font-semibold mb-2">
                            selamat datang kembali
                        </p>

                        <h2 class="text-5xl font-extrabold text-slate-800 tracking-tight">
                            Selamat Datang Karyawan
                        </h2>

                        <p class="text-slate-500 text-lg mt-3">
                            Dashboard presensi dan aktivitas harian Anda.
                        </p>
                    </div>

                    <div
                        class="px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl">
                        <p class="text-sm uppercase tracking-widest opacity-80">
                            Divisi
                        </p>
                        <p class="text-2xl font-bold mt-1">
                            {{ session('karyawan_divisi', 'Divisi') }}
                        </p>
                    </div>
                </div>

                {{-- STATISTICS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">

                    {{-- HADIR --}}
                    <div class="bg-white rounded-3xl shadow-xl border border-blue-100 p-6">
                        <p class="text-sm uppercase tracking-widest text-slate-500 font-semibold mb-3">
                            Hadir
                        </p>
                        <p class="text-6xl font-extrabold text-emerald-600 text-center">
                            {{ $hadir ?? 0 }}
                        </p>
                    </div>

                    {{-- TERLAMBAT --}}
                    <div class="bg-white rounded-3xl shadow-xl border border-blue-100 p-6">
                        <p class="text-sm uppercase tracking-widest text-slate-500 font-semibold mb-3">
                            Terlambat
                        </p>
                        <p class="text-6xl font-extrabold text-amber-500 text-center">
                            {{ $terlambat ?? 0 }}
                        </p>
                    </div>

                    {{-- TIDAK HADIR --}}
                    <div class="bg-white rounded-3xl shadow-xl border border-blue-100 p-6">
                        <p class="text-sm uppercase tracking-widest text-slate-500 font-semibold mb-3">
                            Tidak Hadir
                        </p>
                        <p class="text-6xl font-extrabold text-red-500 text-center">
                            {{ $tidakHadir ?? 0 }}
                        </p>
                    </div>

                    {{-- IZIN --}}
                    <div class="bg-white rounded-3xl shadow-xl border border-blue-100 p-6">
                        <p class="text-sm uppercase tracking-widest text-slate-500 font-semibold mb-3">
                            Izin
                        </p>
                        <p class="text-6xl font-extrabold text-blue-600 text-center">
                            {{ $izin ?? 0 }}
                        </p>
                    </div>

                </div>

                {{-- PROFILE + CLOCK CARD --}}
                <div class="bg-white rounded-3xl shadow-2xl border border-blue-100 p-8 mb-6">

                    <div class="flex flex-col xl:flex-row justify-between gap-8">

                        {{-- PROFILE --}}
                        <div class="flex items-center gap-6">
                            <div
                                class="w-28 h-28 rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-4xl font-extrabold text-white shadow-xl">
                                {{ strtoupper(substr(session('karyawan_nama', 'Karyawan'), 0, 3)) }}
                            </div>

                            <div>
                                <p class="text-sm uppercase tracking-[0.25em] text-slate-500 font-semibold mb-2">
                                    Karyawan profil
                                </p>

                                <h3 class="text-4xl font-extrabold text-slate-800 tracking-tight">
                                    {{ session('karyawan_nama', 'Karyawan') }}
                                </h3>

                                <p class="text-2xl text-slate-500 mt-2">
                                    {{ session('karyawan_jabatan', 'Karyawan') }}
                                </p>
                            </div>
                        </div>

                        {{-- CLOCK --}}
                        <div class="text-right">
                            <p class="text-sm uppercase tracking-[0.25em] text-blue-600 font-semibold mb-2">
                                Waktu Sekarang
                            </p>

                            <div id="clock"
                                class="text-7xl font-extrabold text-slate-800 leading-none tracking-tight">
                                08 : 57
                            </div>

                            <div id="date"
                                class="text-lg text-slate-500 mt-3 font-medium">
                                Kamis, 2 Nov 2026
                            </div>
                        </div>

                    </div>

                    {{-- ACTION BUTTONS --}}
                    {{-- Ganti bagian ACTION BUTTONS dengan kode berikut --}}

                    <div class="flex justify-end gap-4 mt-8">

                        {{-- Tombol Masuk --}}
                        <form action="{{ route('karyawan.absensi.masuk') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-48 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-2xl font-bold text-xl shadow-xl hover:shadow-2xl hover:scale-105 transition duration-300">
                                Masuk
                            </button>
                        </form>

                        {{-- Tombol Pulang --}}
                        <form action="{{ route('karyawan.absensi.pulang') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-48 bg-white border border-blue-100 text-slate-700 py-4 rounded-2xl font-bold text-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition duration-300">
                                Pulang
                            </button>
                        </form>

                    </div>

                </div>

                {{-- ACTIVITY SECTION --}}
                <div>
                    <div class="mb-4">
                        <p class="text-sm uppercase tracking-[0.25em] text-blue-600 font-semibold mb-2">
                            Daily Activity
                        </p>
                        <h3 class="text-3xl font-extrabold text-slate-800">
                            Aktivitas Hari Ini
                        </h3>
                    </div>

                    {{-- TABLE CARD --}}
                    <div
                        class="bg-white rounded-3xl shadow-2xl border border-blue-100 overflow-hidden">

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">

                                {{-- TABLE HEADER --}}
                                <thead
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                                    <tr>
                                        <th class="px-6 py-4 text-left font-bold">No</th>
                                        <th class="px-6 py-4 text-left font-bold">Nama Karyawan</th>
                                        <th class="px-6 py-4 text-left font-bold">Tanggal</th>
                                        <th class="px-6 py-4 text-left font-bold">jam masuk</th>
                                        <th class="px-6 py-4 text-left font-bold">jam pulang</th>
                                        <th class="px-6 py-4 text-left font-bold">Keterangan</th>
                                    </tr>
                                </thead>

                                {{-- GANTI BAGIAN TBODY PADA ACTIVITY SECTION MENJADI INI --}}

                                <tbody>
                                    @php
                                    $aktivitas = $aktivitas ?? collect();
                                    @endphp

                                    @forelse($aktivitas as $item)
                                    <tr
                                        class="border-b border-slate-100 hover:bg-blue-50 transition duration-200">

                                        {{-- NO --}}
                                        <td class="px-6 py-4 font-medium text-slate-700">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- NAMA --}}
                                        <td class="px-6 py-4 font-semibold text-slate-800">
                                            {{ session('karyawan_nama') }}
                                        </td>

                                        {{-- TANGGAL --}}
                                        <td class="px-6 py-4 text-slate-600">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                        </td>

                                        {{-- JAM MASUK --}}
                                        <td class="px-6 py-4 font-semibold text-green-600">
                                            {{ $item->jam_masuk ?? '-' }}
                                        </td>

                                        {{-- JAM PULANG --}}
                                        <td class="px-6 py-4 font-semibold text-red-500">
                                            {{ $item->jam_keluar ?? '-' }}
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-3 py-1 rounded-full text-sm font-semibold
                    @if(($item->status ?? '-') == 'Hadir')
                        bg-green-100 text-green-700
                    @elseif(($item->status ?? '-') == 'Terlambat')
                        bg-yellow-100 text-yellow-700
                    @elseif(($item->status ?? '-') == 'Izin')
                        bg-blue-100 text-blue-700
                    @else
                        bg-red-100 text-red-700
                    @endif">

                                                {{ $item->status ?? '-' }}

                                            </span>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6"
                                            class="py-16 text-center text-slate-400 italic text-lg">
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

    {{-- CLOCK SCRIPT (TIDAK DIUBAH) --}}
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

</body>

</html>