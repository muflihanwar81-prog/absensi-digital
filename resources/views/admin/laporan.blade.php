<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - CODIA-SYNC</title>
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
    @include('layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 overflow-y-auto">

        {{-- HEADER --}}
        @include('components.header_admin')
        
        {{-- PAGE TITLE --}}
        <div class="px-6 pt-6">
            <div class="bg-white border border-slate-200/80 rounded-2xl px-6 py-6 shadow-sm">
                <p class="text-blue-600 font-semibold uppercase tracking-wider text-xs mb-1">
                    Reporting System
                </p>

                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                    Laporan
                </h1>

                <p class="text-slate-500 mt-1.5 text-sm">
                    Kelola dan ekspor laporan absensi karyawan.
                </p>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="p-6">

            {{-- FILTER CARD --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 mb-6">

                <div class="flex flex-wrap gap-4 items-center">

                    {{-- SEARCH --}}
                    <input
                        type="text"
                        placeholder="Pencarian..."
                        class="bg-white border border-slate-200 px-4 py-2 rounded-xl text-sm outline-none w-72 text-slate-700 placeholder-slate-400 shadow-sm focus:border-blue-500 transition-all duration-200">

                    {{-- DATE START --}}
                    <input
                        type="date"
                        class="bg-white border border-slate-200 px-4 py-2 rounded-xl text-sm outline-none text-slate-750 shadow-sm focus:border-blue-500 transition-all duration-200">

                    {{-- LABEL --}}
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider px-2">
                        S/D
                    </span>

                    {{-- DATE END --}}
                    <input
                        type="date"
                        class="bg-white border border-slate-200 px-4 py-2 rounded-xl text-sm outline-none text-slate-750 shadow-sm focus:border-blue-500 transition-all duration-200">

                    {{-- FILTER BUTTON --}}
                    <button
                        class="bg-white border border-slate-200 shadow-sm px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Filter
                    </button>

                    {{-- EXPORT BUTTONS --}}
                    <div class="ml-auto flex gap-3">

                        {{-- EXCEL --}}
                        <a href="{{ route('admin.laporan.excel') }}"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl font-semibold text-sm shadow-sm shadow-emerald-500/10 hover:scale-[1.02] transition-all">
                            Excel
                        </a>

                        {{-- PDF --}}
                        <a href="{{ route('admin.laporan.pdf') }}"
                            class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-xl font-semibold text-sm shadow-sm shadow-rose-500/10 hover:scale-[1.02] transition-all">
                            PDF
                        </a>

                    </div>

                </div>

            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200/80">

                {{-- TABLE HEADER --}}
                <div class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-800 tracking-tight">
                        Data Laporan Kehadiran Karyawan
                    </h2>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full border-collapse">

                        <thead
                            class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-semibold text-xs uppercase tracking-wider">

                            <tr>
                                <th class="px-6 py-3.5 text-left font-semibold">No</th>
                                <th class="px-6 py-3.5 text-left font-semibold">NIP</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Nama</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Divisi</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Jabatan</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Jam Masuk</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Jam Keluar</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Tanggal</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($data as $item)

                            <tr
                                class="border-t border-slate-100 hover:bg-slate-50/70 text-slate-700 text-sm transition duration-150">

                                {{-- NOMOR --}}
                                <td class="px-6 py-4 font-mono font-medium text-slate-500">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 font-mono font-semibold text-slate-800">{{ optional($item->karyawan)->nip ?? '-' }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ optional($item->karyawan)->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-650">{{ optional($item->karyawan)->divisi ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-650">{{ optional($item->karyawan)->jabatan ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 font-mono">
                                        {{ $item->jam_masuk ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20 font-mono">
                                        {{ $item->jam_keluar ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-550 font-mono text-xs">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>

                            </tr>

                            @empty

                            <tr>
                                <td
                                    colspan="8"
                                    class="text-center py-20 text-slate-400 italic text-sm">
                                    Data kosong
                                </td>
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