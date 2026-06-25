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
            @include('components.header')

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
                <div class="flex justify-end mb-6">
                    <button
                        onclick="openModal()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm shadow-blue-500/10 hover:scale-[1.02] transition-all">
                        + Ajukan Izin
                    </button>
                </div>

                {{-- CARD UTAMA --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

                    {{-- HEADER CARD --}}
                    <div class="bg-slate-50 border-b border-slate-200/80 px-8 py-5 text-slate-800">
                        
                        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                            Pengajuan Izin
                        </h2>
                        <p class="mt-1 text-slate-500 text-sm">
                            Kelola dan pantau seluruh pengajuan izin Anda.
                        </p>
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
                                            <th class="px-6 py-3.5 text-left font-semibold">NIP</th>
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

                                                <td class="px-4 py-4 text-center">
                                                    <button
                                                        type="button"
                                                        onclick="openDetailModal(
                                                            '{{ addslashes($item->nip) }}',
                                                            '{{ addslashes($item->nama) }}',
                                                            '{{ addslashes($item->divisi) }}',
                                                            '{{ addslashes($item->jabatan) }}',
                                                            '{{ addslashes($item->kategori) }}',
                                                            '{{ $item->tanggal_mulai }}',
                                                            '{{ $item->tanggal_selesai }}',
                                                            '{{ $item->status }}',
                                                            '{{ $item->file_tambahan ? asset('/storage/' . $item->file_tambahan) : '' }}', 
                                                            '{{ addslashes(basename($item->file_tambahan ?? ''))}}',
                                                        )"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20 font-semibold text-xs hover:bg-blue-100 transition">
                                                        <i class="fa-solid fa-eye mr-1 text-xs"></i>
                                                        Detail
                                                    </button>
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

    {{-- MODAL AJUKAN IZIN --}}
    <div
        id="modalIzin"
        class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-50 p-4">

        <div
            class="bg-white w-full max-w-lg rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

            {{-- HEADER MODAL --}}
            <div
                class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 text-slate-800 flex justify-between items-center">
                <div>
                    <p class="text-xxs uppercase tracking-wider font-bold text-slate-400 mb-0.5">
                        New Request
                    </p>
                    <h2 class="text-base font-bold text-slate-800 tracking-tight">
                        Ajukan Izin
                    </h2>
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

                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                        NIP
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
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
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
    </script>

</body>

</html>