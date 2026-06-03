<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kehadiran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 h-screen flex flex-col overflow-hidden">

{{-- Navbar --}}
<nav class="bg-sky-400 px-6 py-3 flex justify-between items-center shadow z-10">
    <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-full bg-white/30 flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
        </div>
        <span class="text-white font-bold text-lg tracking-wide">CODIA-SYNC</span>
    </div>

    {{-- Dropdown User --}}
    <div class="relative">
        <button id="dropdownButton" data-dropdown-toggle="dropdown"
            class="flex items-center gap-2 text-sm bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition font-medium">
            Hallo, {{ auth()->user()->name }}
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div id="dropdown" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-lg z-50">
            <ul class="py-2 text-sm text-gray-700">
                <li><a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100 rounded-t-xl">Profile</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 rounded-b-xl text-red-500">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="flex flex-1 overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-52 bg-sky-400 flex flex-col justify-between py-4 shrink-0">
        <ul class="flex flex-col gap-1 px-3">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10' }} text-sm transition">
                    Dashboard Kehadiran
                </a>
            </li>
            <li>
                <a href="{{ route('kehadiran.index') }}"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-lg {{ request()->routeIs('kehadiran.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10' }} text-sm transition">
                    Data Kehadiran
                </a>
            </li>
            <li>
                <a href="{{ route('izin.index') }}"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-lg {{ request()->routeIs('izin.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10' }} text-sm transition">
                    Pengajuan Izin
                </a>
            </li>
            <li>
                <a href="{{ route('lembur.index') }}"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-lg {{ request()->routeIs('lembur.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10' }} text-sm transition">
                    Pengajuan Lembur
                </a>
            </li>
        </ul>

        {{-- User Badge --}}
        <div class="flex items-center gap-3 px-4 py-3">
            <div class="w-9 h-9 rounded-full bg-sky-700 flex items-center justify-center text-white font-bold text-sm shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <span class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</span>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 overflow-y-auto bg-gray-50 p-8">

        <div class="flex items-center justify-between mb-1">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Selamat Datang Karyawan.</h2>
                <p class="text-gray-400 text-sm mt-0.5">Tanggal {{ now()->translatedFormat('j M Y') }}</p>
            </div>
            <button class="bg-gray-200 hover:bg-gray-300 text-gray-600 text-sm px-4 py-2 rounded-lg transition font-medium">
                Filter
            </button>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-5">
            <div class="bg-green-500 rounded-xl p-4 text-white shadow">
                <p class="text-xs font-semibold uppercase tracking-wider opacity-80">Hadir</p>
                <p class="text-3xl font-bold mt-2">{{ $hadir }}</p>
            </div>
            <div class="bg-orange-400 rounded-xl p-4 text-white shadow">
                <p class="text-xs font-semibold uppercase tracking-wider opacity-80">Terlambat</p>
                <p class="text-3xl font-bold mt-2">{{ $terlambat }}</p>
            </div>
            <div class="bg-blue-500 rounded-xl p-4 text-white shadow">
                <p class="text-xs font-semibold uppercase tracking-wider opacity-80">Izin</p>
                <p class="text-3xl font-bold mt-2">{{ $izin }}</p>
            </div>
            <div class="bg-red-500 rounded-xl p-4 text-white shadow">
                <p class="text-xs font-semibold uppercase tracking-wider opacity-80">Tanpa Keterangan</p>
                <p class="text-3xl font-bold mt-2">{{ $tanpaKeterangan }}</p>
            </div>
        </div>

        <hr class="my-6 border-gray-200"/>
        {{-- Tombol Kehadiran --}}
        <div>
            <h3 class="text-base font-semibold text-gray-700 mb-3">Kehadiran</h3>
            <div class="grid grid-cols-2 gap-4">
                <form method="POST" action="{{ route('absensi.masuk') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-green-400 hover:bg-green-500 active:scale-95 transition text-white font-bold text-lg py-4 rounded-xl shadow-sm">
                        Masuk
                    </button>
                </form>
                <form method="POST" action="{{ route('absensi.pulang') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-400 hover:bg-red-500 active:scale-95 transition text-white font-bold text-lg py-4 rounded-xl shadow-sm">
                        Pulang
                    </button>
                </form>
            </div>
        </div>
        <hr class="my-6 border-gray-200"/>
        {{-- Tabel Riwayat --}}
        <div>
            <h3 class="text-base font-semibold text-gray-700 mb-4">Riwayat Kehadiran Hari ini</h3>
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                            <tr>
                                <th class="px-6 py-3">Nama</th>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Jam Masuk</th>
                                <th class="px-6 py-3">Jam Pulang</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayat as $item)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $item->user->name }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal }}</td>
                                <td class="px-6 py-4">{{ $item->jam_masuk ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->jam_pulang ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if ($item->status === 'Hadir')
                                        <span class="bg-green-100 text-green-600 font-semibold text-xs px-3 py-1 rounded-full">Hadir</span>
                                    @elseif ($item->status === 'Terlambat')
                                        <span class="bg-orange-100 text-orange-500 font-semibold text-xs px-3 py-1 rounded-full">Terlambat</span>
                                    @elseif ($item->status === 'Izin')
                                        <span class="bg-blue-100 text-blue-600 font-semibold text-xs px-3 py-1 rounded-full">Izin</span>
                                    @else
                                        <span class="bg-red-100 text-red-500 font-semibold text-xs px-3 py-1 rounded-full">Tanpa Keterangan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-400">Belum ada riwayat kehadiran hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>