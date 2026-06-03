<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kehadiran</title>
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

        {{-- Sidebar Karyawan --}}
        @include('layouts.sidebar_karyawan')

        {{-- Main Content --}}
        <div class="flex-1 min-w-0">

            {{-- Header --}}
            @include('components.header')

            {{-- Content --}}
            <div class="p-6">

                {{-- Container --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

                    {{-- Title Section --}}
                    <div class="bg-slate-50 border-b border-slate-200/80 px-8 py-5 text-slate-800">
                        <p class="uppercase tracking-wider text-xxs font-bold text-slate-400 mb-1">
                            Attendance Records
                        </p>
                        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                            Data Kehadiran Anda
                        </h2>
                        <p class="mt-1 text-slate-500 text-sm">
                            Riwayat kehadiran dan status absensi karyawan.
                        </p>
                    </div>

                    {{-- Filter Section --}}
                    <div class="p-6 border-b border-slate-100 bg-slate-50/20">
                        <form method="GET" action="{{ route('karyawan.kehadiran') }}">
                            <div class="flex flex-wrap items-center gap-4">

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

                                {{-- Filter Dropdown --}}
                                <div class="ml-auto flex flex-wrap items-center gap-3">

                                    {{-- Bulan --}}
                                    <select
                                        name="bulan"
                                        class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-700 shadow-sm focus:outline-none cursor-pointer focus:border-blue-500 transition">
                                        <option value="">Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option
                                            value="{{ $i }}"
                                            {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                            </option>
                                            @endfor
                                    </select>

                                    {{-- Status --}}
                                    <select
                                        name="status"
                                        class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-700 shadow-sm focus:outline-none cursor-pointer focus:border-blue-500 transition">
                                        <option value="">Status</option>
                                        <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="Tidak Hadir" {{ request('status') == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                        <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                    </select>

                                    {{-- Button Filter --}}
                                    <button
                                        type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold shadow-sm shadow-blue-500/10 hover:scale-[1.02] transition-all">
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="p-6">
                        <div class="overflow-x-auto rounded-xl border border-slate-200/80 shadow-sm">

                            <table class="w-full text-sm">

                                {{-- Table Header --}}
                                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                                    <tr>
                                        <th class="px-6 py-3.5 text-center font-semibold">No</th>
                                        <th class="px-6 py-3.5 text-left font-semibold">Nama Karyawan</th>
                                        <th class="px-6 py-3.5 text-left font-semibold">Tanggal</th>
                                        <th class="px-6 py-3.5 text-left font-semibold">Jam Masuk</th>
                                        <th class="px-6 py-3.5 text-left font-semibold">Jam Keluar</th>
                                        <th class="px-6 py-3.5 text-center font-semibold">Status</th>
                                        <th class="px-6 py-3.5 text-center font-semibold">Aksi</th>
                                    </tr>
                                </thead>

                                {{-- Table Body --}}
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($absensis as $item)
                                    <tr class="hover:bg-slate-50/70 text-slate-700 text-sm transition duration-150">

                                        {{-- No --}}
                                        <td class="px-6 py-4 text-center font-mono font-medium text-slate-500">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- Nama --}}
                                        <td class="px-6 py-4 font-bold text-slate-800">
                                            {{ $item->nama_karyawan ?? session('karyawan_nama') }}
                                        </td>

                                        {{-- Tanggal --}}
                                        <td class="px-6 py-4 font-mono text-slate-600 text-xs">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                        </td>

                                        {{-- Jam Masuk --}}
                                        <td class="px-6 py-4 font-semibold text-emerald-600 font-mono">
                                            {{ $item->jam_masuk ?? '-' }}
                                        </td>

                                        {{-- Jam Keluar --}}
                                        <td class="px-6 py-4 font-semibold text-rose-500 font-mono">
                                            {{ $item->jam_keluar ?? '-' }}
                                        </td>

                                        {{-- Status --}}
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold
                                                @if(($item->status ?? '-') == 'Hadir')
                                                    bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20
                                                @elseif(($item->status ?? '-') == 'Izin')
                                                    bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20
                                                @elseif(($item->status ?? '-') == 'Terlambat')
                                                    bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20
                                                @else
                                                    bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20
                                                @endif">

                                                {{ $item->status ?? '-' }}

                                            </span>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-6 py-4 text-center">
                                            <button
                                                type="button"
                                                class="bg-blue-50 hover:bg-blue-100 text-blue-700 ring-1 ring-inset ring-blue-600/10 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                                <i class="fa-solid fa-eye mr-1"></i> Detail
                                            </button>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7"
                                            class="text-center py-24 text-slate-400 italic text-sm">
                                            Belum ada data kehadiran.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>