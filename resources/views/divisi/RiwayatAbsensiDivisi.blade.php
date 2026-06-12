<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absen - CODIA-SYNC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50 antialiased font-sans">

    <div class="flex">
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">

            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 shadow-lg">
                <h2 class="text-3xl font-bold text-white">Riwayat Absensi</h2>
            </div>

            <!-- Content -->
            <div class="p-8">
            
                {{-- SEARCH & FILTER: Form pencarian data absensi --}}
                <div class="flex gap-4 items-center mb-6">
                    {{-- Form GET → dikirim ke controller index() untuk filter data --}}
                    <form
                        action="{{ route('divisi.riwayat-absensi') }}"
                        method="GET"
                        class="flex-1 flex gap-4 items-center">

                        {{-- Input pencarian: NIP, nama, divisi, atau jabatan --}}
                        <div class="flex-1">
                            <div
                                class="bg-white border border-slate-250 rounded-xl px-4 py-2.5 flex items-center gap-3 shadow-sm focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all duration-205">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-slate-450"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>

                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}" {{-- Pertahankan nilai search setelah submit --}}
                                    placeholder="Cari NIP, nama, divisi, atau jabatan..."
                                    class="w-full bg-transparent outline-none text-sm font-medium text-slate-700 placeholder-slate-400">
                            </div>
                        </div>

                        {{-- Tombol submit filter --}}
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm shadow-blue-500/10 hover:scale-[1.02] transition-all duration-200">
                            Filter
                        </button>
                        {{-- Tanggal --}}
                                <div class="flex flex-wrap items-center gap-2.5">
                                    <label class="font-bold text-slate-500 text-xxs uppercase tracking-wider">
                                        Tanggal:
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_awal"
                                        value="{{ request('tanggal_awal') }}"
                                        class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-750 shadow-sm focus:outline-none focus:border-blue-500 transition">

                                    <span class="font-bold text-slate-400 text-xs uppercase tracking-wider px-1">
                                        s/d
                                    </span>

                                    <input
                                        type="date"
                                        name="tanggal_akhir"
                                        value="{{ request('tanggal_akhir') }}"
                                        class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-750 shadow-sm focus:outline-none focus:border-blue-500 transition">
                                </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="bg-white border border-blue-200 rounded-xl overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-100 border-b border-blue-200 text-[11px] font-bold text-blue-900 uppercase tracking-tighter">
                                <th class="py-3 px-2 border-r border-blue-200 w-10 text-center">No</th>
                                <th class="py-3 px-3 border-r border-blue-200">NIP</th>
                                <th class="py-3 px-3 border-r border-blue-200">Nama</th>
                                <th class="py-3 px-3 border-r border-blue-200">Divisi</th>
                                <th class="py-3 px-3 border-r border-blue-200">Jabatan</th>
                                <th class="py-3 px-3 border-r border-blue-200">Jam Masuk</th>
                                <th class="py-3 px-3 border-r border-blue-200">Jam Keluar</th>
                                <th class="py-3 px-3 border-r border-blue-200">Tanggal</th>
                                <th class="py-3 px-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($absensi as $a)
                            <tr class="border-b border-blue-100 hover:bg-blue-50/50 transition">
                                <td class="py-3 px-2 border-r border-blue-200 text-center text-blue-900 font-semibold text-sm">{{ $loop->iteration }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-950 font-bold text-sm">{{ optional($a->karyawan)->nip ?? '-' }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-sm font-semibold">{{ optional($a->karyawan)->nama ?? '-' }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-sm">{{ optional($a->karyawan)->divisi ?? '-' }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-sm">{{ optional($a->karyawan)->jabatan ?? '-' }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-emerald-600 font-bold text-sm">{{ $a->jam_masuk ?? '-' }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-rose-600 font-bold text-sm">{{ $a->jam_keluar ?? '-' }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-sm font-medium">{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>
                                <td class="py-3 px-3 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $a->status === 'Hadir' ? 'bg-green-100 text-green-700' : ($a->status === 'Terlambat' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $a->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr class="h-96">
                                <td colspan="9"
                                    class="text-center text-blue-300 italic text-sm font-medium">
                                    Tidak ada data riwayat absensi untuk ditampilkan...
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</body>
</html>