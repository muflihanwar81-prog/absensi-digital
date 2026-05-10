<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Perizinan - CODIA-SYNC</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 flex font-sans h-screen overflow-hidden">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 h-screen overflow-y-auto">

        {{-- Header --}}
        @include('components.header-admin')

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
                                Data Perizinan
                            </h1>
                            <p class="text-slate-500 mt-3 text-lg">
                                Kelola seluruh pengajuan izin karyawan secara terpusat.
                            </p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-3xl px-8 py-6 shadow-lg text-center min-w-[220px]">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">
                                Total Perizinan
                            </p>
                            <h2 class="text-5xl font-extrabold text-blue-700">
                                {{ $perizinan->count() }}
                            </h2>
                        </div>
                    </div>
                </div>

                {{-- SEARCH BAR --}}
                <div class="mb-6">
                    <form action="{{ route('admin.perizinan.index') }}" method="GET">
                        <div
                            class="bg-white border border-blue-100 rounded-2xl px-5 py-3 flex items-center gap-4 shadow-lg w-full max-w-md">

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
                                placeholder="Cari NIP, nama, atau jenis izin..."
                                class="w-full bg-transparent outline-none text-lg font-medium text-slate-700 placeholder-slate-400">
                        </div>
                    </form>
                </div>

                {{-- TABLE CONTAINER --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-2xl border border-blue-100 min-h-[500px]">

                    <table class="w-full border-collapse">

                        {{-- TABLE HEADER --}}
                        <thead
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm uppercase tracking-wide">
                            <tr>
                                <th class="px-4 py-4 w-12 text-center">
                                    <input type="checkbox"
                                        class="rounded border-white/50 bg-white/20 text-white focus:ring-white">
                                </th>
                                <th class="px-4 py-4 text-left">NIP</th>
                                <th class="px-4 py-4 text-left">Nama</th>
                                <th class="px-4 py-4 text-left">Jenis Izin</th>
                                <th class="px-4 py-4 text-left">Tanggal</th>
                                <th class="px-4 py-4 text-center">Status</th>
                                <th class="px-4 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        {{-- TABLE BODY --}}
                        <tbody>
                            @forelse($perizinan as $p)
                                <tr
                                    class="border-t border-slate-100 hover:bg-blue-50 transition duration-200 text-sm text-slate-700">

                                    <td class="px-4 py-4 text-center">
                                        <input type="checkbox"
                                            class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    </td>

                                    <td class="px-4 py-4 font-mono font-semibold uppercase text-slate-700">
                                        {{ $p->nip }}
                                    </td>

                                    <td class="px-4 py-4 uppercase font-semibold text-slate-800">
                                        {{ $p->nama }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $p->jenis }}
                                    </td>

                                    <td class="px-4 py-4 text-slate-600">
                                        {{ $p->tanggal }}
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold
                                            {{ $p->status == 'Disetujui'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ $p->status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        <a href="#"
                                            class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-100 text-blue-700 font-semibold hover:bg-blue-200 transition">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="h-[400px] text-center text-slate-400 italic text-xl">
                                        Belum ada data perizinan masuk.
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
