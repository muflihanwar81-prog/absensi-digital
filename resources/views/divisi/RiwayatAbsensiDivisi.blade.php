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

            
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 shadow-lg">
                <h2 class="text-3xl font-bold text-white">Riwayat Absensi</h2>
            </div>

            
            <div class="p-8">

                
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <div class="flex-1 min-w-[300px]">
                        <input type="text"
                               placeholder="Pencarian.."
                               class="w-full p-3 bg-white rounded-xl border border-blue-200 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-400 font-semibold text-sm text-blue-900">
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="text"
                               placeholder="Rentang Tanggal"
                               class="p-3 bg-white rounded-xl border border-blue-200 shadow-sm text-sm font-semibold w-40 text-center text-blue-900 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                        <span class="font-bold text-blue-700">S/D</span>

                        <input type="text"
                               placeholder="Rentang Tanggal"
                               class="p-3 bg-white rounded-xl border border-blue-200 shadow-sm text-sm font-semibold w-40 text-center text-blue-900 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>
                </div>

                
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
