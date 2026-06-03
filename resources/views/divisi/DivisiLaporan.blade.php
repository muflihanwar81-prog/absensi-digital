<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - CODIA-SYNC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50 antialiased font-sans">

    <div class="flex">
        
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">
            
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 shadow-lg">
                <h2 class="text-3xl font-bold text-white">Laporan</h2>
            </div>

            
            <div class="p-8">
                
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    
                    
                    <div class="flex items-center gap-3 flex-wrap">
                        <input type="text"
                               placeholder="Pencarian.."
                               class="p-3 bg-white rounded-xl border border-blue-200 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-400 font-semibold text-sm text-blue-900 w-64">

                        <div class="flex items-center gap-2">
                            <input type="text"
                                   placeholder="Rentang Tanggal"
                                   class="p-3 bg-white rounded-xl border border-blue-200 shadow-sm text-[11px] font-semibold w-32 text-center text-blue-900 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                            <span class="font-bold text-blue-700 text-xs">S/D</span>

                            <input type="text"
                                   placeholder="Rentang Tanggal"
                                   class="p-3 bg-white rounded-xl border border-blue-200 shadow-sm text-[11px] font-semibold w-32 text-center text-blue-900 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        </div>

                        <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl font-bold text-sm text-white shadow-sm transition">
                            Filter
                        </button>
                    </div>

                    
                    <div class="flex items-center gap-3">
                        <a href="{{ route('divisi.laporan.excel') }}" class="px-8 py-3 bg-green-600 hover:bg-green-700 rounded-xl font-bold text-sm text-white shadow-sm transition uppercase">
                            Excel
                        </a>

                        <a href="{{ route('divisi.laporan.pdf') }}" class="px-8 py-3 bg-red-600 hover:bg-red-700 rounded-xl font-bold text-sm text-white shadow-sm transition uppercase">
                            PDF
                        </a>
                    </div>
                </div>

                
                <div class="bg-white border border-blue-200 rounded-xl overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-100 border-b border-blue-200 text-[11px] font-bold text-blue-900 uppercase tracking-tight">
                                <th class="py-3 px-2 border-r border-blue-200 w-12 text-center">No</th>
                                <th class="py-3 px-3 border-r border-blue-200">NIP</th>
                                <th class="py-3 px-3 border-r border-blue-200">Nama</th>
                                <th class="py-3 px-3 border-r border-blue-200">Divisi</th>
                                <th class="py-3 px-3 border-r border-blue-200">Jabatan</th>
                                <th class="py-3 px-3 border-r border-blue-200">Jam Masuk</th>
                                <th class="py-3 px-3 border-r border-blue-200">Jam Keluar</th>
                                <th class="py-3 px-3">Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($absensi as $a)
                            <tr class="border-b border-blue-100 hover:bg-blue-50/50 transition">
                                <td class="py-3 px-2 border-r border-blue-200 text-center text-blue-900 font-semibold text-sm">{{ $loop->iteration }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-950 font-bold text-sm">{{ optional($a->karyawan)->nip ?? '-' }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-sm font-semibold">{{ optional($a->karyawan)->nama ?? '-' }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-sm">{{ optional($a->karyawan)->divisi ?? $a->divisi }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-sm">{{ optional($a->karyawan)->jabatan ?? '-' }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-emerald-600 font-bold text-sm">{{ $a->jam_masuk ?? '-' }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-rose-600 font-bold text-sm">{{ $a->jam_keluar ?? '-' }}</td>
                                <td class="py-3 px-3 text-blue-900 text-sm font-medium">{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>
                            </tr>
                            @empty
                            <tr class="h-96">
                                <td colspan="8"
                                    class="text-center text-blue-300 italic text-sm font-medium">
                                    Data laporan belum tersedia...
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
