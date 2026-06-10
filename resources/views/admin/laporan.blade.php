<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - CODIA-SYNC</title>
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

<body class="bg-slate-50 text-slate-900 font-sans selection:bg-blue-600 selection:text-white">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 overflow-y-auto">

        {{-- HEADER atas halaman admin --}}
        @include('components.header_admin')
        
        {{-- PAGE TITLE: Judul halaman laporan --}}
        <div class="px-6 pt-6">
            <div class="bg-white border border-slate-200/80 rounded-2xl px-6 py-6 shadow-sm animate-welcome-left">
                <p class="text-blue-600 font-semibold uppercase tracking-wider text-xs mb-1">
                    Reporting System
                </p>

                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                    Laporan
                </h1>

                <p class="text-slate-500 mt-1.5 text-sm">
                    Kelola dan ekspor laporan absensi karyawan.
                </p>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="p-6">

        {{-- FILTER CARD: Real-time filter tanpa klik button --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 mb-6 animate-card delay-100">
                <div class="flex flex-wrap gap-4 items-center">

                    {{-- Input pencarian umum: NIP, jabatan --}}
                    <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2 shadow-sm focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20 transition-all w-56">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm"></i>
                        <input
                            id="filterSearch"
                            type="text"
                            placeholder="Cari NIP, jabatan..."
                            class="bg-transparent outline-none text-sm text-slate-700 placeholder-slate-400 w-full">
                    </div>

                    {{-- Filter divisi dropdown --}}
                    <div class="relative">
                        <select
                            id="filterDivisi"
                            class="bg-white border border-slate-200 rounded-xl pl-9 pr-8 py-2 text-sm outline-none text-slate-700 shadow-sm focus:border-blue-500 transition appearance-none cursor-pointer">
                            <option value="">Semua Divisi</option>
                            @foreach($daftarDivisi as $div)
                                <option value="{{ $div }}">{{ $div }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-building text-slate-400 text-xs absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-xs absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    {{-- Filter nama: dropdown dinamis sesuai divisi dipilih --}}
                    <div class="relative">
                        <select
                            id="filterNama"
                            class="bg-white border border-slate-200 rounded-xl pl-9 pr-8 py-2 text-sm outline-none text-slate-700 shadow-sm focus:border-blue-500 transition appearance-none cursor-pointer min-w-[180px]">
                            <option value="">Semua Karyawan</option>
                        </select>
                        <i class="fa-solid fa-user text-slate-400 text-xs absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-xs absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    {{-- Filter tanggal mulai --}}
                    <input
                        id="filterTanggalAwal"
                        type="date"
                        class="bg-white border border-slate-200 px-4 py-2 rounded-xl text-sm outline-none text-slate-700 shadow-sm focus:border-blue-500 transition-all duration-200">

                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">S/D</span>

                    {{-- Filter tanggal akhir --}}
                    <input
                        id="filterTanggalAkhir"
                        type="date"
                        class="bg-white border border-slate-200 px-4 py-2 rounded-xl text-sm outline-none text-slate-700 shadow-sm focus:border-blue-500 transition-all duration-200">

                    {{-- Tombol reset --}}
                    <button
                        id="btnReset"
                        onclick="resetFilter()"
                        class="hidden bg-white border border-slate-200 shadow-sm px-4 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition items-center gap-1">
                        <i class="fa-solid fa-xmark text-xs"></i> Reset
                    </button>

                    {{-- TOMBOL EXPORT --}}
                    <div class="ml-auto flex gap-3">
                        <a href="{{ route('admin.laporan.excel') }}"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl font-semibold text-sm shadow-sm shadow-emerald-500/10 hover:scale-[1.02] transition-all">
                            <i class="fa-solid fa-file-excel mr-1"></i> Excel
                        </a>
                        <a href="{{ route('admin.laporan.pdf') }}"
                            class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-xl font-semibold text-sm shadow-sm shadow-rose-500/10 hover:scale-[1.02] transition-all">
                            <i class="fa-solid fa-file-pdf mr-1"></i> PDF
                        </a>
                    </div>

                </div>
            </div>

            {{-- Info counter hasil filter --}}
            <div id="filterInfo" class="hidden mb-4 flex flex-wrap items-center gap-2 text-sm text-slate-500">
                <i class="fa-solid fa-filter text-blue-500 text-xs"></i>
                <span>Menampilkan <span id="filterCount" class="font-bold text-slate-700">0</span> hasil</span>
                <span id="filterBadgeSearch" class="hidden bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded-lg text-xs font-semibold border border-blue-100 items-center gap-1">
                    <i class="fa-solid fa-magnifying-glass text-xxs"></i> <span id="filterBadgeSearchText"></span>
                </span>
                <span id="filterBadgeDivisi" class="hidden bg-purple-50 text-purple-700 px-2.5 py-0.5 rounded-lg text-xs font-semibold border border-purple-100 items-center gap-1">
                    <i class="fa-solid fa-building text-xxs"></i> <span id="filterBadgeDivisiText"></span>
                </span>
                <span id="filterBadgeNama" class="hidden bg-indigo-50 text-indigo-700 px-2.5 py-0.5 rounded-lg text-xs font-semibold border border-indigo-100 items-center gap-1">
                    <i class="fa-solid fa-user text-xxs"></i> <span id="filterBadgeNamaText"></span>
                </span>
                <span id="filterBadgeTanggal" class="hidden bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-lg text-xs font-semibold items-center gap-1">
                    <i class="fa-solid fa-calendar text-xxs"></i> <span id="filterBadgeTanggalText"></span>
                </span>
            </div>

            {{-- TABLE CARD: Tampilkan data laporan absensi dari controller --}}
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200/80 animate-card delay-200">

                {{-- Judul tabel --}}
                <div class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-800 tracking-tight">
                        Data Laporan Kehadiran Karyawan
                    </h2>
                    <span class="text-xs font-semibold text-slate-400">
                        <span id="tableCount">{{ $data->count() }}</span> record
                    </span>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full border-collapse">

                        {{-- Kolom header tabel --}}
                        <thead
                            class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-semibold text-xs uppercase tracking-wider">

                            <tr>
                                <th class="px-6 py-3.5 text-left font-semibold">No</th>
                                <th class="px-6 py-3.5 text-left font-semibold">NIP</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Nama</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Divisi</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Jabatan</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Jam Masuk</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Jam Keluar</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Tanggal</th>
                            </tr>

                        </thead>

                        <tbody>

                            {{-- Loop $data dari AdminLaporanController::index() --}}
                            @forelse ($data as $item)

                            <tr
                                data-nip="{{ optional($item->karyawan)->nip ?? '' }}"
                                data-nama="{{ strtolower(optional($item->karyawan)->nama ?? '') }}"
                                data-divisi="{{ optional($item->karyawan)->divisi ?? '' }}"
                                data-jabatan="{{ strtolower(optional($item->karyawan)->jabatan ?? '') }}"
                                data-tanggal="{{ $item->tanggal }}"
                                class="tabel-row border-t border-slate-100 hover:bg-slate-50/70 text-slate-700 text-sm transition duration-150">

                                {{-- Nomor urut otomatis --}}
                                <td class="px-6 py-4 font-mono font-medium text-slate-500">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- Data karyawan diambil lewat relasi (optional untuk hindari error jika null) --}}
                                <td class="px-6 py-4 font-mono font-semibold text-slate-800">{{ optional($item->karyawan)->nip ?? '-' }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ optional($item->karyawan)->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-650">{{ optional($item->karyawan)->divisi ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-650">{{ optional($item->karyawan)->jabatan ?? '-' }}</td>

                                {{-- Badge jam masuk hijau --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 font-mono">
                                        {{ $item->jam_masuk ?? '-' }}
                                    </span>
                                </td>

                                {{-- Badge jam keluar merah --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20 font-mono">
                                        {{ $item->jam_keluar ?? '-' }}
                                    </span>
                                </td>

                                {{-- Format tanggal ke dd-mm-yyyy menggunakan Carbon --}}
                                <td class="px-6 py-4 text-slate-550 font-mono text-xs">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>

                            </tr>

                            @empty
                            {{-- Tampilkan pesan jika tidak ada data --}}
                            <tr id="emptyRow">
                                <td colspan="8" class="text-center py-20 text-slate-400 italic text-sm">
                                    Data kosong
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

</div>

<script>
    // Data karyawan per divisi dari PHP
    const karyawanPerDivisi = @json($karyawanPerDivisi);

    const elSearch       = document.getElementById('filterSearch');
    const elDivisi       = document.getElementById('filterDivisi');
    const elNama         = document.getElementById('filterNama');
    const elTglAwal      = document.getElementById('filterTanggalAwal');
    const elTglAkhir     = document.getElementById('filterTanggalAkhir');
    const elReset        = document.getElementById('btnReset');
    const elFilterInfo   = document.getElementById('filterInfo');
    const elFilterCount  = document.getElementById('filterCount');
    const elTableCount   = document.getElementById('tableCount');
    const rows           = document.querySelectorAll('.tabel-row');
    const totalRows      = rows.length;

    // Dropdown nama: update isi sesuai divisi yang dipilih
    function updateNamaDropdown(divisi) {
        const current = elNama.value;
        elNama.innerHTML = '<option value="">Semua Karyawan</option>';

        let list = [];
        if (!divisi) {
            Object.values(karyawanPerDivisi).forEach(arr => { list = list.concat(arr); });
            list = [...new Set(list)].sort();
        } else {
            list = karyawanPerDivisi[divisi] || [];
        }

        list.forEach(nama => {
            const opt = document.createElement('option');
            opt.value = nama;
            opt.textContent = nama;
            if (nama === current) opt.selected = true;
            elNama.appendChild(opt);
        });

        // Setelah update nama dropdown, jalankan filter ulang
        applyFilter();
    }

    //Filter utama: sembunyikan/tampilkan baris tabel 
    function applyFilter() {
        const search  = elSearch.value.trim().toLowerCase();
        const divisi  = elDivisi.value;
        const nama    = elNama.value.toLowerCase();
        const tglAwal = elTglAwal.value;   // format: YYYY-MM-DD
        const tglAkhir = elTglAkhir.value;

        let visibleCount = 0;
        let rowNum = 1;

        rows.forEach(row => {
            const rNip     = row.dataset.nip.toLowerCase();
            const rNama    = row.dataset.nama;
            const rDivisi  = row.dataset.divisi;
            const rJabatan = row.dataset.jabatan;
            const rTanggal = row.dataset.tanggal; // format: YYYY-MM-DD

            // Cek semua kondisi filter
            const matchSearch  = !search  || rNip.includes(search) || rNama.includes(search) || rJabatan.includes(search);
            const matchDivisi  = !divisi  || rDivisi === divisi;
            const matchNama    = !nama    || rNama === nama;
            const matchTglAwal  = !tglAwal  || rTanggal >= tglAwal;
            const matchTglAkhir = !tglAkhir || rTanggal <= tglAkhir;

            const visible = matchSearch && matchDivisi && matchNama && matchTglAwal && matchTglAkhir;

            row.style.display = visible ? '' : 'none';

            if (visible) {
                // Update nomor urut hanya baris yang tampil
                const tdNo = row.querySelector('td:first-child');
                if (tdNo) tdNo.textContent = rowNum++;
                visibleCount++;
            }
        });

        // Update counter
        elTableCount.textContent = visibleCount;
        elFilterCount.textContent = visibleCount;

        // Tampilkan/sembunyikan info bar dan tombol reset
        const hasFilter = search || divisi || nama || tglAwal || tglAkhir;

        if (hasFilter) {
            elFilterInfo.classList.remove('hidden');
            elFilterInfo.classList.add('flex');
            elReset.classList.remove('hidden');
            elReset.classList.add('flex');
        } else {
            elFilterInfo.classList.add('hidden');
            elFilterInfo.classList.remove('flex');
            elReset.classList.add('hidden');
            elReset.classList.remove('flex');
        }

        // Update badge info
        updateBadge('filterBadgeSearch', 'filterBadgeSearchText', search ? `"${elSearch.value.trim()}"` : '');
        updateBadge('filterBadgeDivisi', 'filterBadgeDivisiText', divisi);
        updateBadge('filterBadgeNama',   'filterBadgeNamaText',   elNama.value);
        if (tglAwal || tglAkhir) {
            const fmt = d => d ? new Date(d).toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' }) : '...';
            updateBadge('filterBadgeTanggal', 'filterBadgeTanggalText', `${fmt(tglAwal)} — ${fmt(tglAkhir)}`);
        } else {
            updateBadge('filterBadgeTanggal', 'filterBadgeTanggalText', '');
        }

        // Tampilkan baris kosong jika tidak ada hasil
        const emptyRow = document.getElementById('emptyRow');
        if (emptyRow) emptyRow.style.display = visibleCount === 0 ? '' : 'none';
    }

    function updateBadge(badgeId, textId, value) {
        const badge = document.getElementById(badgeId);
        const text  = document.getElementById(textId);
        if (!badge || !text) return;
        if (value) {
            text.textContent = value;
            badge.classList.remove('hidden');
            badge.classList.add('flex');
        } else {
            badge.classList.add('hidden');
            badge.classList.remove('flex');
        }
    }

    // ─── Reset semua filter ─────────────────────────────────────────────────
    function resetFilter() {
        elSearch.value    = '';
        elDivisi.value    = '';
        elTglAwal.value   = '';
        elTglAkhir.value  = '';
        updateNamaDropdown(''); // reset nama dropdown juga
    }

    // ─── Event listeners — real-time, tanpa klik button ────────────────────
    elSearch.addEventListener('input', applyFilter);
    elDivisi.addEventListener('change', function() { updateNamaDropdown(this.value); });
    elNama.addEventListener('change', applyFilter);
    elTglAwal.addEventListener('change', applyFilter);
    elTglAkhir.addEventListener('change', applyFilter);

    // ─── Init: isi dropdown nama dengan semua karyawan saat halaman pertama load
    document.addEventListener('DOMContentLoaded', function() {
        updateNamaDropdown('');
    });
</script>

</body>
</html>