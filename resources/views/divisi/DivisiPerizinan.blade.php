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

                {{-- SEARCH & FILTER: Form pencarian data absensi --}}
                <div class="flex gap-4 items-center mb-6">
                    {{-- Form GET → dikirim ke controller index() untuk filter data --}}
                    <form
                        action="{{ route('divisi.data-perizinan') }}"
                        method="GET"
                        class="flex-1 flex gap-4 items-center">

                        {{-- Input pencarian: NIP, nama, divisi, atau jabatan --}}
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
                                    value="{{ request('search') }}" {{-- Pertahankan nilai search setelah submit --}}
                                    placeholder="Cari NIP, nama, divisi, atau jabatan..."
                                    class="w-full bg-transparent outline-none text-sm font-medium text-slate-700 placeholder-slate-400">
                            </div>
                        </div>

                        {{-- Tombol submit filter --}}
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm shadow-blue-500/10 hover:scale-[1.02] transition-all duration-200">
                            Filter
                        </button>
                        {{-- Tanggal --}}
                                <div class="flex flex-wrap items-center gap-2.5">
                                    <label class="font-bold text-slate-500 text-xxs uppercase tracking-wider">
                                        Tanggal:
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_awal"
                                        value="{{ request('tanggal_awal') }}"
                                        class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-750 shadow-sm focus:outline-none focus:border-blue-500 transition">

                                    <span class="font-bold text-slate-400 text-xs uppercase tracking-wider px-1">
                                        s/d
                                    </span>

                                    <input
                                        type="date"
                                        name="tanggal_akhir"
                                        value="{{ request('tanggal_akhir') }}"
                                        class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-750 shadow-sm focus:outline-none focus:border-blue-500 transition">
                                </div>
                    </form>
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
                                <td class="py-3 px-3 border-r border-blue-200 text-blue-900 text-xs font-semibold">
                                    @if($i->tanggal_mulai && $i->tanggal_selesai)
                                        {{ \Carbon\Carbon::parse($i->tanggal_mulai)->format('d-m-Y') }}
                                        @if($i->tanggal_mulai !== $i->tanggal_selesai)
                                            <br><span class="text-[10px] text-blue-600 font-bold">s/d</span><br>
                                            {{ \Carbon\Carbon::parse($i->tanggal_selesai)->format('d-m-Y') }}
                                        @endif
                                    @else
                                        {{ $i->created_at->format('d-m-Y') }}
                                    @endif
                                </td>
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

                                            <button type="button" 
                                                    onclick="openRejectModal({{ $i->id }})" 
                                                    class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm hover:shadow">
                                                Tolak
                                            </button>
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

    <div id="rejectModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-all">
        <div class="bg-white rounded-2xl border border-blue-100 shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
            
            <div class="bg-gradient-to-r from-rose-600 to-rose-500 p-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">Alasan Penolakan</h3>
                <button type="button" onclick="closeRejectModal()" class="text-white/80 hover:text-white font-bold text-xl">&times;</button>
            </div>

            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="p-6">
                    <p class="text-xs font-semibold text-slate-500 mb-3 uppercase tracking-wider">Silakan masukkan alasan penolakan izin:</p>
                    
                    <textarea 
                        name="alasan_tolak" 
                        id="alasan_tolak" 
                        rows="4" 
                        required
                        placeholder="Contoh: Kuota divisi penuh / Dokumen bukti tidak valid.." 
                        class="w-full p-3 bg-slate-50 rounded-xl border border-slate-200 shadow-inner focus:ring-2 focus:ring-rose-400 focus:outline-none placeholder-slate-400 font-medium text-sm text-slate-800 resize-none"></textarea>
                </div>

                <div class="bg-slate-50 p-4 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" onclick="closeRejectModal()" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg text-xs font-bold transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm">
                        Kirim & Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            const textarea = document.getElementById('alasan_tolak');
            
            // Mengubah action form target secara dinamis berdasarkan id baris data
            form.action = `/perizinan/tolak/${id}`; 
            
            // Memunculkan modal ke layar
            modal.classList.remove('hidden');
            textarea.focus();
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            const textarea = document.getElementById('alasan_tolak');
            
            // Menyembunyikan modal kembali
            modal.classList.add('hidden');
            textarea.value = '';
        }

        // Fitur penutup otomatis jika pengguna mengklik area luar modal (backdrop hitam)
        window.onclick = function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target == modal) {
                closeRejectModal();
            }
        }
    </script>
</body>
</html>