<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Karyawan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex">

<!-- SIDEBAR -->
<aside class="w-64 h-screen bg-blue-500 text-white flex flex-col justify-between">

    <div>
        <div class="p-5 text-xl font-bold border-b border-blue-400">
            CODIA-SYNC
        </div>

        <ul class="p-4 space-y-3">
            <li class="bg-blue-700 p-2 rounded">Dashboard Kehadiran</li>
            <li><a href="/riwayat" class="block p-2 hover:bg-blue-600 rounded">Data Kehadiran</a></li>
            <li><a href="/izin" class="block p-2 hover:bg-blue-600 rounded">Pengajuan Izin</a></li>
            <li><a href="#" class="block p-2 hover:bg-blue-600 rounded">Pengajuan Lembur</a></li>
        </ul>
    </div>

    <div class="p-4 border-t border-blue-400 flex items-center gap-2">
        <div class="bg-white text-black w-10 h-10 flex items-center justify-center rounded-full font-bold">
            {{ strtoupper(substr(auth()->user()->name,0,2)) }}
        </div>
        <div>{{ auth()->user()->name }}</div>
    </div>

</aside>

<!-- MAIN -->
<main class="flex-1 p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold">Selamat Datang Karyawan</h1>
            <p class="text-gray-500">{{ now()->format('d M Y') }}</p>
        </div>

        <form method="POST" action="/logout">
            @csrf
            <button class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
                Logout
            </button>
        </form>
    </div>

    <!-- NOTIF -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- CARD STAT -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

        <div class="bg-green-600 text-white p-4 rounded-xl shadow">
            <p>HADIR</p>
            <h2 class="text-2xl font-bold">{{ $hadir ?? 0 }}</h2>
        </div>

        <div class="bg-orange-400 text-white p-4 rounded-xl shadow">
            <p>TERLAMBAT</p>
            <h2 class="text-2xl font-bold">{{ $terlambat ?? 0 }}</h2>
        </div>

        <div class="bg-blue-500 text-white p-4 rounded-xl shadow">
            <p>IZIN</p>
            <h2 class="text-2xl font-bold">{{ $izin ?? 0 }}</h2>
        </div>

        <div class="bg-red-500 text-white p-4 rounded-xl shadow">
            <p>ALPHA</p>
            <h2 class="text-2xl font-bold">{{ $alpha ?? 0 }}</h2>
        </div>

    </div>

    <!-- ABSEN -->
    <div class="bg-white p-6 rounded-2xl shadow mb-6">

        <h2 class="text-xl font-semibold mb-4">Kehadiran</h2>

        <div class="flex gap-4">

            <!-- MASUK -->
            <form method="POST" action="/absen-masuk" class="flex-1">
                @csrf
                <button 
                    class="w-full bg-green-500 text-white font-bold py-3 rounded-lg shadow hover:bg-green-600
                    {{ $absensiHariIni ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ $absensiHariIni ? 'disabled' : '' }}
                >
                    {{ $absensiHariIni ? 'Sudah Absen' : 'Masuk' }}
                </button>
            </form>

            <!-- TIDAK HADIR -->
            <form method="POST" action="/tidak-hadir" class="flex-1">
                @csrf
                <button 
                    class="w-full bg-red-500 text-white font-bold py-3 rounded-lg shadow hover:bg-red-600
                    {{ $absensiHariIni ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ $absensiHariIni ? 'disabled' : '' }}
                >
                    Tidak Hadir
                </button>
            </form>

        </div>
    </div>

    <!-- RIWAYAT HARI INI -->
    <div class="bg-white p-6 rounded-2xl shadow">

        <h2 class="text-xl font-semibold mb-4">Riwayat Hari Ini</h2>

        @if(isset($absensiHariIni) && $absensiHariIni)
            <div class="space-y-2">
                <p><b>Tanggal:</b> {{ $absensiHariIni->tanggal }}</p>
                <p><b>Masuk:</b> {{ $absensiHariIni->jam_masuk ?? '-' }}</p>
                <p><b>Pulang:</b> {{ $absensiHariIni->jam_pulang ?? '-' }}</p>

                <p>
                    <b>Status:</b>
                    <span class="
                        px-2 py-1 rounded text-white
                        @if($absensiHariIni->status == 'hadir') bg-green-500
                        @elseif($absensiHariIni->status == 'terlambat') bg-orange-400
                        @elseif($absensiHariIni->status == 'izin') bg-blue-500
                        @else bg-red-500
                        @endif
                    ">
                        {{ $absensiHariIni->status }}
                    </span>
                </p>
            </div>
        @else
            <p class="text-gray-500">Belum ada absensi hari ini</p>
        @endif

    </div>

</main>

</body>
</html>