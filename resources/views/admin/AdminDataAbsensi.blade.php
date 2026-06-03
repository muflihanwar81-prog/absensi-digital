<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Data Absensi' }} - ADMIN</title>
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

<body class="bg-slate-50 text-slate-900 flex font-sans overflow-hidden">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    <main class="flex-1 h-screen overflow-y-auto">

        {{-- Header --}}
        @include('components.header_admin')

        <div class="p-6">
            <div class="w-full mx-auto px-4 lg:px-6">

                {{-- HEADER CARD --}}
                <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm border border-slate-200/80">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <p class="text-blue-600 font-semibold uppercase tracking-wider text-xs mb-1">
                                Manajemen Data
                            </p>
                            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                                Data Absensi
                            </h1>
                            <p class="text-slate-500 mt-1.5 text-sm">
                                Kelola seluruh data kehadiran karyawan secara terpusat.
                            </p>
                        </div>

                        <div
                            class="bg-slate-50 border border-slate-200/60 rounded-xl px-5 py-3 shadow-sm text-center min-w-[160px]">
                            <p class="text-xxs font-bold uppercase tracking-wider text-slate-400 mb-1">
                                Total Absensi
                            </p>
                            <h2 class="text-2xl font-extrabold text-slate-800 font-mono">
                                {{ $absensi->count() }}
                            </h2>
                        </div>
                    </div>
                </div>

                {{-- SEARCH & FILTER --}}
                <div class="flex gap-4 items-center mb-6">
                    <form
                        action="{{ route('admin.absensi.index') }}"
                        method="GET"
                        class="flex-1 flex gap-4 items-center">

                        {{-- SEARCH --}}
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
                                    value="{{ request('search') }}"
                                    placeholder="Cari NIP, nama, divisi, atau jabatan..."
                                    class="w-full bg-transparent outline-none text-sm font-medium text-slate-700 placeholder-slate-400">
                            </div>
                        </div>

                        {{-- BUTTON FILTER --}}
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm shadow-blue-500/10 hover:scale-[1.02] transition-all duration-200">
                            Filter
                        </button>
                    </form>
                </div>

                {{-- TABEL DATA ABSENSI --}}
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200/80 min-h-[500px]">

                    <table class="w-full border-collapse">

                        {{-- TABLE HEADER --}}
                        <thead
                            class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-4 text-center w-16 font-semibold">No</th>
                                <th class="px-4 py-4 text-left font-semibold">NIP</th>
                                <th class="px-4 py-4 text-left font-semibold">Nama</th>
                                <th class="px-4 py-4 text-left font-semibold">Divisi</th>
                                <th class="px-4 py-4 text-left font-semibold">Jabatan</th>
                                <th class="px-4 py-4 text-left font-semibold">Jam Masuk</th>
                                <th class="px-4 py-4 text-left font-semibold">Jam Keluar</th>
                                <th class="px-4 py-4 text-left font-semibold">Tanggal</th>
                                <th class="px-4 py-4 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>

                        {{-- TABLE BODY --}}
                        <tbody>
                            @forelse($absensi as $index => $a)
                                <tr
                                    class="border-t border-slate-100 hover:bg-slate-50/70 transition duration-150 text-sm text-slate-750">

                                    <td class="px-4 py-4 text-center font-mono font-medium text-slate-500">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="px-4 py-4 font-mono font-semibold text-slate-800">
                                        {{ $a->nip }}
                                    </td>

                                    <td class="px-4 py-4 font-semibold text-slate-800">
                                        {{ $a->nama }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $a->divisi }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $a->jabatan }}
                                    </td>

                                    <td class="px-4 py-4">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 font-mono">
                                            {{ $a->jam_masuk }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20 font-mono">
                                            {{ $a->jam_keluar }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-slate-500 font-mono text-xs">
                                        {{ $a->tanggal }}
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        <a
                                            href="#"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20 font-semibold text-xs transition hover:bg-blue-100">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="9"
                                        class="h-[400px] text-center text-slate-400 italic text-sm">
                                        Data absensi tidak ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </main>

</body>

</html>
