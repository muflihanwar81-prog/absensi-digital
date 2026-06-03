<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Perizinan - CODIA-SYNC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50 antialiased font-sans">

    <div class="flex">
        
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">

            
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 shadow-lg">
                <h2 class="text-3xl font-bold text-white">Data Perizinan</h2>
            </div>

            
            <div class="p-8">

                
                @if (session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl shadow-sm font-semibold text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('danger'))
                    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-6 py-4 rounded-xl shadow-sm font-semibold text-sm">
                        {{ session('danger') }}
                    </div>
                @endif

                
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <div class="flex-1 min-w-[300px]">
                        <input type="text"
                               placeholder="Pencarian.."
                               class="w-full p-3 bg-white rounded-xl border border-blue-200 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-400 font-semibold text-sm text-blue-900">
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="text"
                               placeholder="Rentang Tanggal"
                               class="p-3 bg-white rounded-xl border border-blue-200 shadow-sm text-[12px] font-semibold w-36 text-center text-blue-900 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                        <span class="font-bold text-blue-700 text-sm">S/D</span>

                        <input type="text"
                               placeholder="Rentang Tanggal"
                               class="p-3 bg-white rounded-xl border border-blue-200 shadow-sm text-[12px] font-semibold w-36 text-center text-blue-900 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>
                </div>

                
                <div class="bg-white border border-blue-200 rounded-xl overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-100 border-b border-blue-200 text-[11px] font-bold text-blue-900 uppercase">
                                <th class="py-3 px-2 border-r border-blue-200 w-10 text-center">No</th>
                                <th class="py-3 px-3 border-r border-blue-200">NIP</th>
                                <th class="py-3 px-3 border-r border-blue-200">Nama</th>
                                <th class="py-3 px-3 border-r border-blue-200">Divisi</th>
                                <th class="py-3 px-3 border-r border-blue-200">Jabatan</th>
                                <th class="py-3 px-3 border-r border-blue-200">Kategori</th>
                                <th class="py-3 px-3 border-r border-blue-200">Bukti</th>
                                <th class="py-3 px-3 border-r border-blue-200">Tanggal</th>
                                <th class="py-3 px-3 border-r border-blue-200 text-center w-28">Status</th>
                                <th class="py-3 px-3 text-center w-48">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($data as $i)
                            <tr class="border-b border-blue-100 hover:bg-blue-50/50 transition">
                                <td class="py-3 px-2 border-r border-blue-200 text-center text-blue-900 font-semibold text-sm">{{ $loop->iteration }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-950 font-bold text-sm">{{ $i->nip }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-sm font-semibold">{{ $i->nama }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-sm">{{ $i->divisi }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-sm">{{ $i->jabatan }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-sm font-medium text-blue-800">{{ $i->kategori }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-sm text-center">
                                    @if($i->file_tambahan)
                                        <a href="{{ asset('storage/' . $i->file_tambahan) }}" target="_blank" class="text-blue-600 hover:underline font-semibold text-xs">
                                            Lihat Bukti
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-xs font-semibold">{{ $i->created_at->format('d-m-Y') }}</td>
                                <td class="py-3 px-3 border-r border-blue-200 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $i->status === 'Disetujui' ? 'bg-green-100 text-green-700' : ($i->status === 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                        {{ $i->status ?? 'Menunggu' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    @if($i->status === 'Menunggu')
                                        <div class="flex justify-center gap-2">
                                            <form action="{{ route('divisi.perizinan.setujui', $i->id) }}" method="POST" onsubmit="return confirm('Setujui pengajuan izin ini?')">
                                                @csrf
                                                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm hover:shadow">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('divisi.perizinan.tolak', $i->id) }}" method="POST" onsubmit="return confirm('Tolak pengajuan izin ini?')">
                                                @csrf
                                                <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm hover:shadow">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-slate-400 text-xs font-medium">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr class="h-96">
                                <td colspan="10"
                                    class="text-center text-blue-300 italic text-sm font-medium">
                                    Tidak ada data perizinan...
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
