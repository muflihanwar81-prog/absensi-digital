<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - CODIA-SYNC</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
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
<body class="bg-blue-50 antialiased font-sans">

    <div class="flex">
        {{-- SIDEBAR --}}
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">

            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 shadow-lg">
                <h2 class="text-3xl font-bold text-white">Laporan Kehadiran</h2>
            </div>

            <div class="p-8">

                {{-- SEARCH & FILTER: Form pencarian data absensi --}}
                <div class="flex gap-4 items-center mb-6">
                    {{-- Form GET → dikirim ke controller index() untuk filter data --}}
                    <form
                        action="{{ route('divisi.DivisiLaporan') }}"
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
                                                    {{-- EXPORT UTILITIES (Excel & PDF) --}}
                    <div class="w-full md:w-auto flex gap-2 md:ml-auto">
                        <a href="{{ route('divisi.laporan.excel') }}"
                           class="flex-1 md:flex-initial text-center bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl font-bold text-sm shadow-sm transition">
                           <i class="fa-solid fa-file-excel mr-1"></i> Excel
                        </a>
                        <a href="{{ route('divisi.laporan.pdf') }}"
                           class="flex-1 md:flex-initial text-center bg-rose-600 hover:bg-rose-700 text-white px-4 py-3 rounded-xl font-bold text-sm shadow-sm transition">
                           <i class="fa-solid fa-file-pdf mr-1"></i> PDF
                        </a>
                    </div>
                    </form>
                </div>

                <div class="bg-white border border-blue-200 rounded-xl overflow-hidden shadow-sm">

                    <table class="w-full text-left border-collapse">

                        <thead>
                            <tr class="bg-blue-100 border-b border-blue-200 text-sm font-bold text-blue-900">
                                <th class="py-3 px-4 border-r border-blue-200 w-12 text-center">No</th>
                                <th class="py-3 px-4 border-r border-blue-200">NIP</th>
                                <th class="py-3 px-4 border-r border-blue-200">Nama</th>
                                <th class="py-3 px-4 border-r border-blue-200">Divisi</th>
                                <th class="py-3 px-4 border-r border-blue-200">Jabatan</th>
                                <th class="py-3 px-4 border-r border-blue-200">Jam Masuk</th>
                                <th class="py-3 px-4 border-r border-blue-200">Jam Keluar</th>
                                <th class="py-3 px-4 text-center">Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($absensi as $item)
                            <tr class="border-b border-blue-100 hover:bg-blue-50/50 transition">
                                <td class="py-3 px-4 border-r border-blue-200 text-center text-blue-900 font-semibold text-sm">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-blue-950 font-bold text-sm">
                                    {{ optional($item->karyawan)->nip ?? '-' }}
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-blue-900 text-sm font-medium">
                                    {{ optional($item->karyawan)->nama ?? '-' }}
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-blue-900 text-sm">
                                    {{ optional($item->karyawan)->divisi ?? '-' }}
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-blue-900 text-sm">
                                    {{ optional($item->karyawan)->jabatan ?? '-' }}
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-sm">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 font-mono">
                                        {{ $item->jam_masuk ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-sm">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200 font-mono">
                                        {{ $item->jam_keluar ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center text-blue-950 font-mono text-xs font-semibold">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr class="h-64">
                                <td colspan="8" class="text-center text-blue-300 italic font-medium">
                                    Belum ada data laporan absensi
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