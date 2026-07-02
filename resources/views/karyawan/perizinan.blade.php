{{-- resources/views/karyawan/perizinan.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengajuan Izin</title>
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

<body class="bg-slate-50 text-slate-900 flex font-sans h-screen overflow-hidden selection:bg-blue-600 selection:text-white">

    <div class="flex min-h-screen w-full">

        {{-- Sidebar Karyawan --}}
        @include('layouts.sidebar_karyawan')

        {{-- Main Content --}}
        <div id="mainContent"
        class="ml-72 flex-1 transition-all duration-300">

            {{-- HEADER --}}
            <div class="bg-gradient-to-br from-gray-300 to-white-100 backdrop-blur-md border-b border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h1 class="text-xl font-bold tracking-tight text-slate-800">
                            Pengajuan <span class="text-blue-500">Izin</span>
                        </h1>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-xs text-slate-400 font-medium">Selamat Datang</p>
                            <p class="text-sm font-bold text-slate-800">
                                {{ auth()->user()->nama ?? 'Karyawan' }}
                            </p>
                        </div>
                        @php
                            $namaParts = explode(' ', $karyawan->nama);
                            $initials = '';
                            foreach (array_slice($namaParts, 0, 3) as $part) {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                        @endphp
                        <a href="{{ url('/profile') }}" class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/20 ring-2 ring-white/10">
                            {{ $initials ?: 'K' }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- CONTENT --}}
            <main class="flex-1 p-6">

                {{-- ALERT SUCCESS --}}
                @if (session('success'))
                    <div
                        class="mb-6 bg-emerald-50 border border-emerald-255 text-emerald-700 px-5 py-3.5 rounded-xl shadow-sm text-sm font-semibold flex items-center gap-2">
                        <span>✅</span> <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- ALERT ERROR --}}
                @if ($errors->any())
                    <div
                        class="mb-6 bg-rose-50 border border-rose-255 text-rose-700 px-5 py-3.5 rounded-xl shadow-sm text-sm">
                        <ul class="list-disc ml-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- BUTTON TAMBAH IZIN --}}
               

                {{-- CARD UTAMA --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

                    {{-- HEADER CARD --}}
                    <div class="relative bg-gradient-to-br from-blue-100 to-indigo-100 border-b border-slate-200/80 px-8 py-5 text-slate-800">
                        <p class="uppercase tracking-wider text-xxs font-bold text-slate-400 mb-1">
                            Permission Request
                        </p>
                        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                            Data Perizinan Anda
                        </h2>
                        <p class="mt-1 text-slate-500 text-sm">
                            Kelola dan pantau seluruh pengajuan izin Anda.
                        </p>
                        <div class="flex justify-end mb-6">
                            <button
                                onclick="openModal()"
                                class="absolute top-5 right-8 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm shadow-blue-500/10 hover:scale-[1.02] transition-all">
                                + Ajukan Izin
                            </button>
                        </div>
                    </div>

                    <div class="p-6">

                        {{-- TABLE --}}
                        <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden">

                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse">

                                    {{-- TABLE HEADER --}}
                                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                                        <tr>
                                            <th class="px-6 py-3.5 text-left font-semibold">No</th>
                                            <th class="px-6 py-3.5 text-left font-semibold">NIK</th>
                                            <th class="px-6 py-3.5 text-left font-semibold">Nama Karyawan</th>
                                            <th class="px-6 py-3.5 text-left font-semibold">Divisi</th>
                                            <th class="px-6 py-3.5 text-left font-semibold">Jabatan</th>
                                            <th class="px-6 py-3.5 text-left font-semibold">Jenis Izin</th>
                                            <th class="px-6 py-3.5 text-left font-semibold">Tanggal</th>
                                            <th class="px-6 py-3.5 text-center font-semibold">Status</th>
                                            <th class="px-6 py-3.5 text-center font-semibold">Aksi</th>
                                        </tr>
                                    </thead>

                                    {{-- TABLE BODY --}}
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse ($data as $item)
                                            <tr class="hover:bg-slate-50/70 text-slate-700 text-sm transition duration-150">

                                                <td class="px-6 py-4 font-mono font-medium text-slate-500 text-center">
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td class="px-6 py-4 font-mono font-semibold text-slate-800">
                                                    {{ $item->nip }}
                                                </td>

                                                <td class="px-6 py-4 font-bold text-slate-800">
                                                    {{ $item->nama }}
                                                </td>

                                                <td class="px-6 py-4">
                                                    {{ $item->divisi }}
                                                </td>

                                                <td class="px-6 py-4">
                                                    {{ $item->jabatan }}
                                                </td>

                                                <td class="px-6 py-4 font-semibold text-slate-850">
                                                    {{ $item->kategori }}
                                                </td>

                                                <td class="px-6 py-4 text-slate-500 font-mono text-xs">
                                                    @if($item->tanggal_mulai && $item->tanggal_selesai)
                                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}
                                                        @if($item->tanggal_mulai !== $item->tanggal_selesai)
                                                            s/d {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}
                                                        @endif
                                                    @else
                                                        {{ $item->created_at->format('d-m-Y') }}
                                                    @endif
                                                </td>

                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                                        @if ($item->status == 'Disetujui')
                                                            bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20
                                                        @elseif($item->status == 'Ditolak')
                                                            bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20
                                                        @else
                                                            bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20
                                                        @endif">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>

                                                <td class="px-6 py-4 text-center flex items-center justify-center gap-2">
                                                    <button type="button"
                                                            onclick="openDetailModal(
                                                            '{{ addslashes($item->nip) }}',
                                                            '{{ addslashes($item->nama) }}',
                                                            '{{ addslashes($item->divisi) }}',
                                                            '{{ addslashes($item->jabatan) }}',
                                                            '{{ addslashes($item->kategori) }}',
                                                            '{{ $item->tanggal_mulai }}',
                                                            '{{ $item->tanggal_selesai }}',
                                                            '{{ $item->status }}',
                                                            '{{ $item->alasan_tolak }}',
                                                            '{{ $item->file_tambahan ? asset('/storage/' . $item->file_tambahan) : '' }}',
                                                            '{{ addslashes(basename($item->file_tambahan ?? '')) }}',
                                                        )"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20 font-semibold text-xs hover:bg-blue-100 transition">
                                                        <i class="fa-solid fa-eye mr-1 text-xs"></i>
                                                    </button>
                                                    <form action="{{ route('izin.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                                            <i class="fa-solid fa-trash text-xs"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td
                                                    colspan="9"
                                                    class="text-center py-24 text-slate-400 italic text-sm">
                                                    Belum ada pengajuan izin.
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
        </div>
    </div>

    {{-- MODAL DETAIL IZIN --}}

    <div id="modalDetailPerizinan"
        class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-[9999] p-4"
        style="z-index: 9999;">


        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-xl border border-slate-200">

            @forelse ($data as $item)

                <div class="bg-slate-50 border-b rounded-2xl border-slate-200/80 px-6 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-lg font-bold text-black-400 uppercase  mb-0.5">Detail Pengajuan</p>
                    </div>
                    <button type="button" onclick="closeDetailModal()"
                        class="text-slate-400 hover:text-slate-600 text-2xl leading-none">&times;</button>
                </div>


                <div class="p-6  grid grid-cols-2 gap-6">
                    <div class="bg-blue-100/60 rounded-xl p-4 border border-blue-100">
                        <p class="text-sm font-bold text-blue-700 uppercase tracking-wider mb-3">Identitas Karyawan</p>
                        <div class="grid grid-cols-1 gap-3">
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
                        </div>
                    </div>


                    <div class="bg-blue-100/60 rounded-xl p-4 border border-blue-100">
                        <p class="text-sm font-bold text-blue-700 uppercase tracking-wider mb-3">Detail Izin</p>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Jenis Izin</p>
                                <span id="detail_kategori_badge"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold"></span>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Status</p>
                                <span id="detail_status_badge"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold"></span>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Tanggal Mulai</p>
                                <p id="detail_tgl_mulai" class="font-semibold text-slate-800 text-sm font-mono"></p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Tanggal Selesai</p>
                                <p id="detail_tgl_selesai" class="font-semibold text-slate-800 text-sm font-mono"></p>
                            </div>
                        </div>


                        <div class="mt-3 pt-3 border-t border-blue-100">
                            <p class="text-xs text-slate-400 mb-0.5">Durasi</p>
                            <p id="detail_durasi" class="font-bold text-blue-700 text-sm"></p>
                        </div>
                    </div>
                </div>
                <div class="p-6 pt-3">

                    <div class="bg-gradient-to-br from-blue-100 to-white-100 rounded-xl p-4 border border-slate-200/60">
                        <p class="text-sm font-bold text-black-400 uppercase tracking-wider mb-3">Bukti / Lampiran</p>
                        <div id="detail_file_wrapper">

                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-100 to-white-100 rounded-xl p-4 mt-4 border border-slate-200/60">
                        <p class="text-sm font-bold text-black-400 uppercase tracking-wider mb-3">Pesan Status</p>

                        @if ($item->status == 'Menunggu')
                            <div id="detail_alasan_wrapper">
                                <p class="font-semibold text-amber-700 text-sm">"Pengajuan izin sedang menunggu persetujuan dari Kepala Divisi."</p>

                                <p class="mt-3 text-green-600 text-xs"><i class="fas fa-info-circle"></i> Harap bersabar dan menunggu persetujuan.</p>
                            </div>
                        @elseif ($item->status == 'Disetujui')
                            <div id="detail_alasan_wrapper">
                                <p class="font-semibold text-emerald-700 text-sm">"Pengajuan izin telah disetujui."</p>
                            </div>
                        @elseif ($item->status == 'Ditolak')
                            <div id="detail_alasan_wrapper">
                                <p class="font-semibold text-red-700 text-sm">Alasan penolakan: {{ $item->alasan_tolak }}</p>
                            </div>
                        @endif       
                    </div>
                </div>
            @empty
                <div>
                    <p class="font-semibold text-slate-700 text-sm">Tidak ada pengajuan izin yang dipilih.</p>
                </div>
            @endforelse
        </div>
    </div>

    
    {{-- MODAL AJUKAN IZIN --}}
    <div id="modalIzin"                              
        class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-50 p-4">

        <div
            class="bg-white w-full max-w-lg rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

            {{-- HEADER MODAL --}}
            <div
                class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 text-slate-800 flex justify-between items-center">
                <div>
                    <p class="text-xxs uppercase tracking-wider font-bold text-slate-400 mb-0.5">
                        Form Pengajuan Izin
                    </p>
                </div>

                <button
                    onclick="closeModal()"
                    class="text-slate-450 hover:text-slate-650 text-2xl font-bold leading-none">
                    &times;
                </button>
            </div>

            {{-- FORM --}}
            <form
                action="{{ route('izin.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="p-6 space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                            Nik
                        </label>
                        <input
                            type="text"
                            value="{{ $karyawan->nip }}"
                            readonly
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-500 outline-none">
                    </div>
    
                    <div>
                        <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                            Nama
                        </label>
                        <input
                            type="text"
                            value="{{ $karyawan->nama }}"
                            readonly
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                            Divisi
                        </label>
                        <input
                            type="text"
                            value="{{ $karyawan->divisi }}"
                            readonly
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-500 outline-none">
                    </div>

                    <div>
                        <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                            Jabatan
                        </label>
                        <input
                            type="text"
                            value="{{ $karyawan->jabatan }}"
                            readonly
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                        Kategori
                    </label>
                    <div class="relative">
                        <select
                            name="kategori"
                            required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm text-slate-700">
                            <option value="">Pilih Kategori</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Cuti">Cuti</option>
                        </select>
                        
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                            Tanggal Mulai
                        </label>
                        <input
                            type="date"
                            name="tanggal_mulai"
                            id="tanggal_mulai"
                            required
                            value="{{ date('Y-m-d') }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-700 outline-none shadow-sm focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                            Tanggal Selesai
                        </label>
                        <input
                            type="date"
                            name="tanggal_selesai"
                            id="tanggal_selesai"
                            required
                            value="{{ date('Y-m-d') }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-700 outline-none shadow-sm focus:border-blue-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                        File Tambahan
                    </label>
                    <input
                        type="file"
                        name="file_tambahan"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none shadow-sm focus:border-blue-500 transition">
                    
                        <p class="mt-1 text-xs text-slate-400">Opsional, Maksimal 5MB. Format: PDF, DOCX, JPG, JPEG, PNG.</p>
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-semibold text-sm transition shadow-sm shadow-blue-500/10">
                    Kirim Pengajuan
                </button>
            </form>

        </div>
    </div>
    

    {{-- SCRIPT MODAL --}}
    <script>
        function openModal() {
            document.getElementById('modalIzin').classList.remove('hidden');
            document.getElementById('modalIzin').classList.add('flex');
        }
        function closeModal() {
            document.getElementById('modalIzin').classList.add('hidden');
            document.getElementById('modalIzin').classList.remove('flex');
        }

        // Tutup modal saat klik area gelap
        document.getElementById('modalIzin').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Tutup dengan ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Validasi Tanggal Mulai & Tanggal Selesai
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalMulaiInput = document.getElementById('tanggal_mulai');
            const tanggalSelesaiInput = document.getElementById('tanggal_selesai');

            if (tanggalMulaiInput && tanggalSelesaiInput) {
                tanggalMulaiInput.addEventListener('change', function() {
                    tanggalSelesaiInput.min = this.value;
                    if (tanggalSelesaiInput.value < this.value) {
                        tanggalSelesaiInput.value = this.value;
                    }
                });
                
                // Set initial min date
                tanggalSelesaiInput.min = tanggalMulaiInput.value;
            }
        });


        function openDetailModal(nip, nama, divisi, jabatan, kategori, tglMulai, tglSelesai, status, fileUrl, fileName) {
        
        document.getElementById('detail_nip').textContent     = nip    || '-';
        document.getElementById('detail_nama').textContent    = nama   || '-';
        document.getElementById('detail_divisi').textContent  = divisi || '-';
        document.getElementById('detail_jabatan').textContent = jabatan || '-';

        
        const kategoriBadge = document.getElementById('detail_kategori_badge');
        kategoriBadge.textContent = kategori || '-';
        kategoriBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold ';
        if (kategori === 'Sakit')     kategoriBadge.className += 'bg-pink-100 text-pink-700';
        else if (kategori === 'Cuti') kategoriBadge.className += 'bg-purple-100 text-purple-700';
        else                          kategoriBadge.className += 'bg-cyan-100 text-cyan-700';

        
        const statusBadge = document.getElementById('detail_status_badge');
        statusBadge.textContent = status || '-';
        statusBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold ';
        if (status === 'Disetujui')     statusBadge.className += 'bg-emerald-100 text-emerald-700';
        else if (status === 'Ditolak')  statusBadge.className += 'bg-rose-100 text-rose-700';
        else                            statusBadge.className += 'bg-amber-100 text-amber-700';

        
        const formatTgl = (tgl) => {
            if (!tgl) return '-';
            const d = new Date(tgl);
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
        };

        document.getElementById('detail_tgl_mulai').textContent   = formatTgl(tglMulai);
        document.getElementById('detail_tgl_selesai').textContent  = formatTgl(tglSelesai);

        
        let durasiText = '-';
        if (tglMulai && tglSelesai) {
            const mulai   = new Date(tglMulai);
            const selesai = new Date(tglSelesai);
            const diffMs  = selesai - mulai;
            const diffHari = Math.round(diffMs / (1000 * 60 * 60 * 24)) + 1; 
            durasiText = diffHari + (diffHari === 1 ? ' hari' : ' hari');
        }
        document.getElementById('detail_durasi').textContent = durasiText;

        
        const fileWrapper = document.getElementById('detail_file_wrapper');
        if (fileUrl && fileUrl !== '') {
            
            const ext = fileName.split('.').pop().toLowerCase();
            const isImage = ['jpg', 'jpeg', 'png'].includes(ext);
            const isPdf   = ext === 'pdf';

            let fileHtml = '';

            if (isImage) {
                
                fileHtml = `
                    <div class="mb-3 rounded-xl overflow-hidden border border-slate-200 bg-slate-100">
                        <img src="${fileUrl}" alt="Bukti Izin"
                            class="w-full max-h-48 object-contain p-2"
                            onerror="this.parentElement.innerHTML='<p class=\\'text-xs text-slate-400 text-center py-6\\'>Gagal memuat gambar</p>'">
                    </div>
                `;
            } else if (isPdf) {
                
                fileHtml = `
                    <div class="flex items-center gap-3 p-3 bg-rose-50 rounded-xl border border-rose-100 mb-3">
                        <div class="w-10 h-10 bg-rose-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-file-pdf text-rose-600 text-lg"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">${fileName}</p>
                            <p class="text-xs text-slate-400">Dokumen PDF</p>
                        </div>
                    </div>
                `;
            } else {
                
                fileHtml = `
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl border border-blue-100 mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-file-lines text-blue-600 text-lg"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">${fileName}</p>
                            <p class="text-xs text-slate-400">Dokumen</p>
                        </div>
                    </div>
                `;
            }

            
            fileHtml += `
                <a href="${fileUrl}" target="_blank"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm transition shadow-sm">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    Buka File
                </a>
            `;

            fileWrapper.innerHTML = fileHtml;
        } else {
            
            fileWrapper.innerHTML = `
                <div class="flex flex-col items-center justify-center py-6 text-slate-400">
                    <i class="fa-solid fa-file-circle-xmark text-3xl mb-2 text-slate-300"></i>
                    <p class="text-sm font-medium">Tidak ada file yang dilampirkan</p>
                </div>
            `;
        }

        
        const modal = document.getElementById('modalDetailPerizinan');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    
    function closeDetailModal() {
        const modal = document.getElementById('modalDetailPerizinan');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('modalDetailPerizinan');
        if (modal && e.target === modal) closeDetailModal();
    });

    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDetailModal();
    });
    </script>

</body>

</html>