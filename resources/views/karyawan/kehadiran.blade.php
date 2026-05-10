<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kehadiran</title>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 font-sans">

    <div class="flex min-h-screen">

        {{-- Sidebar Karyawan --}}
        @include('layouts.sidebar_karyawan')

        {{-- Main Content --}}
        <div class="flex-1">

            {{-- Header --}}
            @include('components.header')

            {{-- Content --}}
            <div class="p-8">

                {{-- Container --}}
                <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-blue-100 overflow-hidden">

                    {{-- Title Section --}}
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6 text-white">
                        <p class="uppercase tracking-[0.3em] text-xs font-semibold opacity-90 mb-2">
                            Attendance Records
                        </p>
                        <h2 class="text-4xl font-extrabold">
                            Data Kehadiran Anda
                        </h2>
                        <p class="mt-2 text-blue-100">
                            Riwayat kehadiran dan status absensi karyawan.
                        </p>
                    </div>

                    {{-- Filter Section --}}
                    <div class="p-8 border-b border-slate-100">
                        <form method="GET" action="{{ route('karyawan.kehadiran') }}">
                            <div class="flex flex-wrap items-end gap-4">

                                {{-- Tanggal --}}
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="font-semibold text-slate-700 text-sm">
                                        Tanggal:
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_awal"
                                        value="{{ request('tanggal_awal') }}"
                                        class="bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                                    <span class="font-semibold text-slate-500 text-sm">
                                        s/d
                                    </span>

                                    <input
                                        type="date"
                                        name="tanggal_akhir"
                                        value="{{ request('tanggal_akhir') }}"
                                        class="bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                {{-- Filter Dropdown --}}
                                <div class="ml-auto flex flex-wrap gap-3">

                                    {{-- Bulan --}}
                                    <select
                                        name="bulan"
                                        class="bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                                        class="bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Status</option>
                                        <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="Tidak Hadir" {{ request('status') == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                        <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                    </select>

                                    {{-- Button Filter --}}
                                    <button
                                        type="submit"
                                        class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-2xl text-sm font-bold shadow-lg hover:shadow-xl hover:scale-105 transition duration-300">
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="p-8">
                        <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">

                            <table class="w-full text-sm">

                                {{-- Table Header --}}
                                <thead class="bg-gradient-to-r from-slate-100 to-blue-50 text-slate-700">
                                    <tr>
                                        <th class="px-4 py-4 text-center font-bold border-b border-slate-200">No</th>
                                        <th class="px-4 py-4 text-left font-bold border-b border-slate-200">Nama Karyawan</th>
                                        <th class="px-4 py-4 text-left font-bold border-b border-slate-200">NIK</th>
                                        <th class="px-4 py-4 text-left font-bold border-b border-slate-200">Divisi</th>
                                        <th class="px-4 py-4 text-left font-bold border-b border-slate-200">Jabatan</th>
                                        <th class="px-4 py-4 text-left font-bold border-b border-slate-200">Tanggal</th>
                                        <th class="px-4 py-4 text-left font-bold border-b border-slate-200">Jam Masuk</th>
                                        <th class="px-4 py-4 text-left font-bold border-b border-slate-200">Jam Keluar</th>
                                        <th class="px-4 py-4 text-center font-bold border-b border-slate-200">Status</th>
                                        <th class="px-4 py-4 text-center font-bold border-b border-slate-200">Aksi</th>
                                    </tr>
                                </thead>

                                {{-- Table Body --}}
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($absensis as $item)
                                        <tr class="hover:bg-blue-50/60 transition duration-200">
                                            <td class="px-4 py-4 text-center font-semibold text-slate-600">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="px-4 py-4 font-semibold text-slate-800">
                                                {{ $item->nama_karyawan ?? session('karyawan_nama') }}
                                            </td>

                                            <td class="px-4 py-4 text-slate-600">
                                                {{ $item->nip ?? '-' }}
                                            </td>

                                            <td class="px-4 py-4 text-slate-600">
                                                {{ $item->divisi ?? '-' }}
                                            </td>

                                            <td class="px-4 py-4 text-slate-600">
                                                {{ $item->jabatan ?? '-' }}
                                            </td>

                                            <td class="px-4 py-4 text-slate-600">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                            </td>

                                            <td class="px-4 py-4 font-semibold text-green-600">
                                                {{ $item->jam_masuk ?? '-' }}
                                            </td>

                                            <td class="px-4 py-4 font-semibold text-red-500">
                                                {{ $item->jam_keluar ?? '-' }}
                                            </td>

                                            <td class="px-4 py-4 text-center">
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold
                                                    @if(($item->status ?? '-') == 'Hadir')
                                                        bg-green-100 text-green-700
                                                    @elseif(($item->status ?? '-') == 'Izin')
                                                        bg-yellow-100 text-yellow-700
                                                    @elseif(($item->status ?? '-') == 'Terlambat')
                                                        bg-orange-100 text-orange-700
                                                    @else
                                                        bg-red-100 text-red-700
                                                    @endif">
                                                    {{ $item->status ?? '-' }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-4 text-center">
                                                <button
                                                    type="button"
                                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-xl shadow-sm transition duration-200">
                                                    👁
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td
                                                colspan="10"
                                                class="text-center py-24 text-slate-400 italic">
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