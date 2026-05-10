<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - CODIA-SYNC</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 font-sans">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 overflow-y-auto">

        {{-- HEADER --}}
        @include('components.header-admin')
        {{-- PAGE TITLE --}}
        <div class="bg-white border-b border-blue-100 px-6 py-6 shadow-sm">
            <p class="text-blue-600 font-semibold uppercase tracking-widest text-sm mb-2">
                Reporting System
            </p>

            <h1 class="text-5xl font-extrabold text-slate-800 tracking-tight">
                Laporan
            </h1>

            <p class="text-slate-500 mt-2 text-lg">
                Kelola dan ekspor laporan absensi karyawan.
            </p>
        </div>

        {{-- CONTENT --}}
        <div class="p-6">

            {{-- FILTER CARD --}}
            <div class="bg-white rounded-3xl shadow-2xl border border-blue-100 p-6 mb-6">

                <div class="flex flex-wrap gap-4 items-center">

                    {{-- SEARCH --}}
                    <input
                        type="text"
                        placeholder="Pencarian..."
                        class="bg-slate-50 border border-blue-100 px-5 py-3 rounded-2xl outline-none w-72 text-slate-700 placeholder-slate-400 shadow-sm focus:ring-2 focus:ring-blue-200">

                    {{-- DATE START --}}
                    <input
                        type="date"
                        class="bg-slate-50 border border-blue-100 px-5 py-3 rounded-2xl outline-none text-slate-700 shadow-sm focus:ring-2 focus:ring-blue-200">

                    {{-- LABEL --}}
                    <span class="font-semibold text-slate-500 px-2">
                        S/D
                    </span>

                    {{-- DATE END --}}
                    <input
                        type="date"
                        class="bg-slate-50 border border-blue-100 px-5 py-3 rounded-2xl outline-none text-slate-700 shadow-sm focus:ring-2 focus:ring-blue-200">

                    {{-- FILTER BUTTON --}}
                    <button
                        class="bg-white border border-blue-100 shadow-lg px-8 py-3 rounded-2xl text-lg font-bold text-slate-700 hover:shadow-xl hover:-translate-y-0.5 transition duration-300">
                        Filter
                    </button>

                    {{-- EXPORT BUTTONS --}}
                    <div class="ml-auto flex gap-4">

                        {{-- EXCEL --}}
                        <button
                            class="bg-gradient-to-r from-emerald-500 to-green-600 text-white px-6 py-3 rounded-2xl shadow-xl font-bold hover:shadow-2xl hover:scale-105 transition duration-300">
                            Excel
                        </button>

                        {{-- PDF --}}
                        <button
                            class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-6 py-3 rounded-2xl shadow-xl font-bold hover:shadow-2xl hover:scale-105 transition duration-300">
                            PDF
                        </button>

                    </div>

                </div>

            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white rounded-3xl overflow-hidden shadow-2xl border border-blue-100">

                {{-- TABLE HEADER --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-2xl font-extrabold text-white">
                        Data Laporan
                    </h2>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full border-collapse">

                        <thead
                            class="bg-slate-50 border-b border-slate-200 text-slate-700 text-sm uppercase tracking-wider">

                            <tr>
                                <th class="px-4 py-4 text-left font-bold">No</th>
                                <th class="px-4 py-4 text-left font-bold">NIP</th>
                                <th class="px-4 py-4 text-left font-bold">Nama</th>
                                <th class="px-4 py-4 text-left font-bold">Divisi</th>
                                <th class="px-4 py-4 text-left font-bold">Jabatan</th>
                                <th class="px-4 py-4 text-left font-bold">Jam Masuk</th>
                                <th class="px-4 py-4 text-left font-bold">Jam Keluar</th>
                                <th class="px-4 py-4 text-left font-bold">Tanggal</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($data as $item)

                            <tr
                                class="border-b border-slate-100 hover:bg-blue-50 transition duration-200">

                                {{-- NOMOR --}}
                                <td class="px-4 py-4 font-medium text-slate-700">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- DATA TETAP DIKOSONGKAN AGAR FUNGSI TIDAK BERUBAH --}}
                                <td class="px-4 py-4 text-slate-600"></td>
                                <td class="px-4 py-4 text-slate-600"></td>
                                <td class="px-4 py-4 text-slate-600"></td>
                                <td class="px-4 py-4 text-slate-600"></td>
                                <td class="px-4 py-4 text-slate-600"></td>
                                <td class="px-4 py-4 text-slate-600"></td>
                                <td class="px-4 py-4 text-slate-600"></td>

                            </tr>

                            @empty

                            <tr>
                                <td
                                    colspan="8"
                                    class="text-center py-20 text-slate-400 italic text-xl">
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