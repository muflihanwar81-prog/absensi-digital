<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Data Absensi' }} - ADMIN</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 flex font-sans overflow-hidden">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    <main class="flex-1 h-screen overflow-y-auto">

        {{-- Header --}}
        @include('pages.header_admin')

        <div class="p-6">
            <div class="w-full mx-auto px-4 lg:px-6">

                {{-- HEADER CARD --}}
                <div class="bg-white rounded-3xl p-8 mb-6 shadow-2xl border border-blue-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-blue-600 font-semibold uppercase tracking-widest text-sm mb-2">
                                Manajemen Data
                            </p>
                            <h1 class="text-5xl font-extrabold text-slate-800 tracking-tight">
                                Data Absensi
                            </h1>
                            <p class="text-slate-500 mt-3 text-lg">
                                Kelola seluruh data kehadiran karyawan secara terpusat.
                            </p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-3xl px-8 py-6 shadow-lg text-center min-w-[220px]">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">
                                Total Absensi
                            </p>
                            <h2 class="text-5xl font-extrabold text-blue-700">
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
                                class="bg-white border border-blue-100 rounded-2xl px-5 py-3 flex items-center gap-4 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-6 h-6 text-blue-600"
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
                                    class="w-full bg-transparent outline-none text-lg font-medium text-slate-700 placeholder-slate-400">
                            </div>
                        </div>

                        {{-- BUTTON FILTER --}}
                        <button
                            type="submit"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition duration-300">
                            Filter
                        </button>
                    </form>
                </div>

                {{-- TABEL DATA ABSENSI --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-2xl border border-blue-100 min-h-[500px]">

                    <table class="w-full border-collapse">

                        {{-- TABLE HEADER --}}
                        <thead
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm uppercase tracking-wide">
                            <tr>
                                <th class="px-4 py-4 text-center w-16">No</th>
                                <th class="px-4 py-4 text-left">NIP</th>
                                <th class="px-4 py-4 text-left">Nama</th>
                                <th class="px-4 py-4 text-left">Divisi</th>
                                <th class="px-4 py-4 text-left">Jabatan</th>
                                <th class="px-4 py-4 text-left">Jam Masuk</th>
                                <th class="px-4 py-4 text-left">Jam Keluar</th>
                                <th class="px-4 py-4 text-left">Tanggal</th>
                                <th class="px-4 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        {{-- TABLE BODY --}}
                        <tbody>
                            @forelse($absensi as $index => $a)
                                <tr
                                    class="border-t border-slate-100 hover:bg-blue-50 transition duration-200 text-sm">

                                    <td class="px-4 py-4 text-center font-medium text-slate-600">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="px-4 py-4 font-mono font-semibold text-slate-700">
                                        {{ $a->nip }}
                                    </td>

                                    <td class="px-4 py-4 font-medium text-slate-800">
                                        {{ $a->nama }}
                                    </td>

                                    <td class="px-4 py-4 text-slate-700">
                                        {{ $a->divisi }}
                                    </td>

                                    <td class="px-4 py-4 text-slate-700">
                                        {{ $a->jabatan }}
                                    </td>

                                    <td class="px-4 py-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-700">
                                            {{ $a->jam_masuk }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-700">
                                            {{ $a->jam_keluar }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-slate-500 italic">
                                        {{ $a->tanggal }}
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        <a
                                            href="#"
                                            class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-100 text-blue-700 font-semibold hover:bg-blue-200 transition">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="9"
                                        class="h-[400px] text-center text-slate-400 italic text-xl">
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
