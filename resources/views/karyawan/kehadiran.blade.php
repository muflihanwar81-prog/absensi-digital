<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kehadiran</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-200">

    <div class="flex min-h-screen">

        @include('layouts.sidebar_karyawan')

        <div class="flex-1">

            <div class="bg-[#efefef] border-b border-gray-400">
                <div class="flex items-center justify-between px-6 py-3">
                    <h1 class="text-3xl font-bold text-gray-800">
                        Presensia
                    </h1>

                    <div class="text-sm font-medium text-gray-700">
                        Hallo, {{ session('karyawan_nama', 'Karyawan') }}
                    </div>
                </div>
            </div>

            <div class="p-6">

                <div class="bg-white border border-gray-400 rounded-lg shadow-sm p-6">

                    <div class="bg-gray-200 rounded-lg px-6 py-4 mb-6">
                        <h2 class="text-4xl font-bold text-gray-800">
                            Data Kehadiran Anda
                        </h2>
                    </div>

                    <form method="GET" action="{{ route('karyawan.kehadiran') }}">
                        <div class="flex flex-wrap items-center gap-4 mb-6">

                            <div class="flex items-center gap-2">
                                <label class="font-semibold text-sm">Tanggal :</label>

                                <input
                                    type="date"
                                    name="tanggal_awal"
                                    value="{{ request('tanggal_awal') }}"
                                    class="border border-gray-400 rounded px-3 py-2 text-sm">

                                <span class="font-semibold text-sm">s/d</span>

                                <input
                                    type="date"
                                    name="tanggal_akhir"
                                    value="{{ request('tanggal_akhir') }}"
                                    class="border border-gray-400 rounded px-3 py-2 text-sm">
                            </div>

                            <div class="ml-auto flex gap-3">

                                <select
                                    name="bulan"
                                    class="border border-gray-400 rounded px-3 py-2 text-sm">
                                    <option value="">Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option
                                        value="{{ $i }}"
                                        {{ request('bulan') == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                        </option>
                                        @endfor
                                </select>

                                <select
                                    name="status"
                                    class="border border-gray-400 rounded px-3 py-2 text-sm">
                                    <option value="">Status</option>
                                    <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="Tidak Hadir" {{ request('status') == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                    <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                </select>

                                <button
                                    type="submit"
                                    class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm font-semibold">
                                    Filter
                                </button>

                            </div>
                        </div>
                    </form>

                    <div class="border border-gray-400 overflow-x-auto">
                        <table class="w-full border-collapse text-sm">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="border border-gray-400 px-3 py-2">No</th>
                                    <th class="border border-gray-400 px-3 py-2">Nama Karyawan</th>
                                    <th class="border border-gray-400 px-3 py-2">Nik</th>
                                    <th class="border border-gray-400 px-3 py-2">Divisi</th>
                                    <th class="border border-gray-400 px-3 py-2">Jabatan</th>
                                    <th class="border border-gray-400 px-3 py-2">Tanggal</th>
                                    <th class="border border-gray-400 px-3 py-2">Jam Masuk</th>
                                    <th class="border border-gray-400 px-3 py-2">Jam Keluar</th>
                                    <th class="border border-gray-400 px-3 py-2">Status</th>
                                    <th class="border border-gray-400 px-3 py-2">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($absensis as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-400 px-3 py-2 text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border border-gray-400 px-3 py-2">
                                        {{ $item->nama_karyawan ?? session('karyawan_nama') }}
                                    </td>

                                    <td class="border border-gray-400 px-3 py-2">
                                        {{ $item->nip ?? '-' }}
                                    </td>

                                    <td class="border border-gray-400 px-3 py-2">
                                        {{ $item->divisi ?? '-' }}
                                    </td>

                                    <td class="border border-gray-400 px-3 py-2">
                                        {{ $item->jabatan ?? '-' }}
                                    </td>

                                    <td class="border border-gray-400 px-3 py-2">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                    </td>

                                    <td class="border border-gray-400 px-3 py-2">
                                        {{ $item->jam_masuk ?? '-' }}
                                    </td>

                                    <td class="border border-gray-400 px-3 py-2">
                                        {{ $item->jam_keluar ?? '-' }}
                                    </td>

                                    <td class="border border-gray-400 px-3 py-2">
                                        {{ $item->status ?? '-' }}
                                    </td>

                                    <td class="border border-gray-400 px-3 py-2 text-center">
                                        <button
                                            type="button"
                                            class="bg-gray-300 hover:bg-gray-400 px-2 py-1 rounded">
                                            👁
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td
                                        colspan="10"
                                        class="border border-gray-400 text-center py-20 text-gray-500">
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

</body>

</html>