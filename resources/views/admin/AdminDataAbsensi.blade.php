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

    {{-- Sidebar navigasi admin --}}
    @include('layouts.sidebar')

    <main class="flex-1 h-screen overflow-y-auto">

        {{-- Header atas halaman admin --}}
        @include('components.header_admin')

        <div class="p-6">
            <div class="w-full mx-auto px-4 lg:px-6">

                {{-- HEADER CARD: Judul halaman + total absensi --}}
                <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm border border-slate-200/80">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div class="animate-welcome-left">
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

                        {{-- Badge counter: menampilkan jumlah total record absensi --}}
                        <div
                            class="bg-slate-50 border border-slate-200/60 rounded-xl px-5 py-3 shadow-sm text-center min-w-[160px] animate-welcome-right">
                            <p class="text-xxs font-bold uppercase tracking-wider text-slate-400 mb-1">
                                Total Absensi
                            </p>
                            <h2 class="text-2xl font-extrabold text-slate-800 font-mono">
                                {{ $absensi->count() }} {{-- Hitung total absensi dari collection --}}
                            </h2>
                        </div>
                    </div>
                </div>

                {{-- NOTIF / ALERTS --}}
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-semibold">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-semibold">{{ session('error') }}</span>
                    </div>
                @endif

                {{-- SEARCH & FILTER: Form pencarian data absensi --}}
                <div class="bg-white rounded-2xl p-5 mb-6 shadow-sm border border-slate-200/80 animate-card delay-100">
                    <form action="{{ route('admin.absensi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        
                        {{-- Input Pencarian --}}
                        <div class="md:col-span-4">
                            <label class="block text-xs font-bold text-slate-450 uppercase tracking-wider mb-2">Pencarian</label>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 flex items-center gap-3 shadow-sm focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari NIP, nama, divisi, jabatan..."
                                    class="w-full bg-transparent outline-none text-sm font-medium text-slate-700 placeholder-slate-400">
                            </div>
                        </div>

                        {{-- Tanggal Awal --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-450 uppercase tracking-wider mb-2">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none text-sm font-medium text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        </div>

                        {{-- Tanggal Akhir --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-450 uppercase tracking-wider mb-2">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none text-sm font-medium text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        </div>

                        {{-- Filter Status --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-450 uppercase tracking-wider mb-2">Status</label>
                            <select name="status"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none text-sm font-medium text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                <option value="">Semua Status</option>
                                <option value="Hadir" {{ request('status') === 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Terlambat" {{ request('status') === 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="Izin" {{ request('status') === 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Sakit" {{ request('status') === 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Alpha" {{ request('status') === 'Alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="md:col-span-2 flex gap-2">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-semibold text-sm shadow-sm transition hover:scale-[1.02] active:scale-[0.98] duration-150 text-center">
                                Filter
                            </button>
                            @if(request()->anyFilled(['search', 'tanggal_awal', 'tanggal_akhir', 'status']))
                                <a href="{{ route('admin.absensi.index') }}"
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-3.5 py-2.5 rounded-xl font-semibold text-sm transition hover:scale-[1.02] active:scale-[0.98] duration-150 flex items-center justify-center"
                                    title="Reset Filter">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                </a>
                            @endif
                        </div>

                    </form>
                </div>

                {{-- TABEL DATA ABSENSI: Tampilkan hasil query dari controller --}}
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200/80 min-h-[500px] animate-card delay-200">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">

                            {{-- Kolom header tabel --}}
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
                                    <th class="px-4 py-4 text-center font-semibold">Status</th>
                                    <th class="px-4 py-4 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>

                            {{-- Baris data: loop $absensi dari controller, tampilkan kosong jika tidak ada --}}
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
                                                {{ $a->jam_masuk ?? '--:--' }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-4">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20 font-mono">
                                                {{ $a->jam_keluar ?? '--:--' }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-4 text-slate-500 font-mono text-xs">
                                            {{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}
                                        </td>

                                        <td class="px-4 py-4 text-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                                @if($a->status == 'Hadir') bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20
                                                @elseif($a->status == 'Terlambat') bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20
                                                @elseif($a->status == 'Izin') bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20
                                                @elseif($a->status == 'Sakit') bg-pink-50 text-pink-700 ring-1 ring-inset ring-pink-600/20
                                                @else bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20 @endif font-mono">
                                                {{ $a->status }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-4 text-center">
                                            <button
                                                type="button"
                                                onclick="openDetailModal(
                                                    '{{ $a->id }}',
                                                    '{{ addslashes($a->nip) }}',
                                                    '{{ addslashes($a->nama) }}',
                                                    '{{ addslashes($a->divisi) }}',
                                                    '{{ addslashes($a->jabatan) }}',
                                                    '{{ $a->jam_masuk ?? '-' }}',
                                                    '{{ $a->jam_keluar ?? '-' }}',
                                                    '{{ $a->tanggal }}',
                                                    '{{ $a->status }}',
                                                    '{{ $a->karyawan ? addslashes($a->karyawan->status) : '-' }}'
                                                )"
                                                class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20 font-semibold text-xs transition hover:bg-blue-100">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td
                                            colspan="10"
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
        </div>

    </main>

    {{-- ============================================================ --}}
    {{-- MODAL DETAIL ABSENSI                                         --}}
    {{-- ============================================================ --}}
    <div id="modalDetailAbsensi"
        class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-[9999] p-4"
        style="z-index: 9999;">

        <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

            {{-- Header modal --}}
            <div class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="text-xxs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Detail Kehadiran</p>
                    <h2 class="text-base font-bold text-slate-800 tracking-tight">Informasi Absensi</h2>
                </div>
                <button type="button" onclick="closeDetailModal()"
                    class="text-slate-400 hover:text-slate-600 text-2xl leading-none">&times;</button>
            </div>

            {{-- Body modal --}}
            <div class="p-6 space-y-5">

                {{-- Info Karyawan --}}
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60">
                    <p class="text-xxs font-bold text-slate-400 uppercase tracking-wider mb-3">Identitas Karyawan</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">NIP</p>
                            <p id="detail_nip" class="font-bold text-slate-800 text-sm font-mono"></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Nama</p>
                            <p id="detail_nama" class="font-bold text-slate-800 text-sm"></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Divisi</p>
                            <p id="detail_divisi" class="font-semibold text-slate-700 text-sm"></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Jabatan</p>
                            <p id="detail_jabatan" class="font-semibold text-slate-700 text-sm"></p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-slate-400 mb-0.5">Status Kepegawaian</p>
                            <p id="detail_karyawan_status" class="font-semibold text-slate-700 text-sm"></p>
                        </div>
                    </div>
                </div>

                {{-- Info Absensi --}}
                <div class="bg-blue-50/60 rounded-xl p-4 border border-blue-100">
                    <p class="text-xxs font-bold text-blue-400 uppercase tracking-wider mb-3">Rincian Absensi</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Status Kehadiran</p>
                            <span id="detail_status_badge"
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono"></span>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Tanggal</p>
                            <p id="detail_tanggal" class="font-semibold text-slate-800 text-sm font-mono"></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Jam Masuk</p>
                            <p id="detail_jam_masuk" class="font-bold text-slate-800 text-sm font-mono"></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Jam Keluar</p>
                            <p id="detail_jam_keluar" class="font-bold text-slate-800 text-sm font-mono"></p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer modal --}}
            <div class="bg-slate-50 border-t border-slate-200/80 px-6 py-4 flex justify-between items-center">
                {{-- Tombol Hapus --}}
                <form id="delete_form" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan absensi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-rose-50 border border-rose-200 hover:bg-rose-100 text-rose-700 px-4 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm flex items-center gap-1.5">
                        <i class="fa-solid fa-trash-can text-xs"></i> Hapus Catatan
                    </button>
                </form>

                <button type="button" onclick="closeDetailModal()"
                    class="bg-white border border-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-slate-50 transition shadow-sm">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <script>
        /**
         * openDetailModal()
         * Mengisi semua field modal dengan data dari baris tabel yang diklik,
         * lalu menampilkan modal ke layar.
         */
        function openDetailModal(id, nip, nama, divisi, jabatan, jamMasuk, jamKeluar, tanggal, status, karyawanStatus) {
            document.getElementById('detail_nip').textContent = nip || '-';
            document.getElementById('detail_nama').textContent = nama || '-';
            document.getElementById('detail_divisi').textContent = divisi || '-';
            document.getElementById('detail_jabatan').textContent = jabatan || '-';
            document.getElementById('detail_karyawan_status').textContent = karyawanStatus || '-';

            document.getElementById('detail_jam_masuk').textContent = jamMasuk || '-';
            document.getElementById('detail_jam_keluar').textContent = jamKeluar || '-';

            // Format Tanggal
            if (tanggal) {
                const d = new Date(tanggal);
                const options = { day: '2-digit', month: 'long', year: 'numeric' };
                document.getElementById('detail_tanggal').textContent = d.toLocaleDateString('id-ID', options);
            } else {
                document.getElementById('detail_tanggal').textContent = '-';
            }

            // Badge status styling
            const badge = document.getElementById('detail_status_badge');
            badge.textContent = status || '-';
            badge.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono ';
            if (status === 'Hadir') {
                badge.className += 'bg-emerald-100 text-emerald-700';
            } else if (status === 'Terlambat') {
                badge.className += 'bg-amber-100 text-amber-700';
            } else if (status === 'Izin') {
                badge.className += 'bg-blue-100 text-blue-700';
            } else if (status === 'Sakit') {
                badge.className += 'bg-pink-100 text-pink-700';
            } else {
                badge.className += 'bg-rose-100 text-rose-700';
            }

            // Set Form Action URL
            document.getElementById('delete_form').action = `/absensi/${id}`;

            // Tampilkan modal
            const modal = document.getElementById('modalDetailAbsensi');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Tutup modal
        function closeDetailModal() {
            const modal = document.getElementById('modalDetailAbsensi');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Tutup modal klik backdrop
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('modalDetailAbsensi');
            if (modal && e.target === modal) closeDetailModal();
        });

        // Tutup modal dengan ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDetailModal();
        });
    </script>

</body>

</html>
