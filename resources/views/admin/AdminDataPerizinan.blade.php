<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Perizinan - CODIA-SYNC</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 flex font-sans h-screen overflow-hidden">

    {{-- Sidebar navigasi admin --}}
    @include('layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 h-screen overflow-y-auto">

        {{-- Header atas halaman admin --}}
        @include('components.header_admin')

        <div class="p-6">
            <div class="w-full mx-auto px-4 lg:px-6">

                {{-- HEADER CARD --}}
                <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm border border-slate-200/80">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div class="animate-welcome-left">
                            <p class="text-blue-600 font-semibold uppercase tracking-wider text-xs mb-1">
                                Manajemen Data
                            </p>
                            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                                Data Perizinan
                            </h1>
                            <p class="text-slate-500 mt-1.5 text-sm">
                                Kelola seluruh pengajuan izin karyawan secara terpusat.
                            </p>
                        </div>
                        <div class="bg-slate-50 border border-slate-200/60 rounded-xl px-5 py-3 shadow-sm text-center min-w-[160px] animate-welcome-right">
                            <p class="text-xxs font-bold uppercase tracking-wider text-slate-400 mb-1">Total Perizinan</p>
                            <h2 class="text-2xl font-extrabold text-slate-800 font-mono">{{ $perizinan->count() }}</h2>
                        </div>
                    </div>
                </div>

                {{-- SEARCH BAR --}}
                <div class="mb-6 animate-card delay-100">
                    <form action="{{ route('admin.perizinan.index') }}" method="GET">
                        <div class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 flex items-center gap-3 shadow-sm focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all duration-200 w-full max-w-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari NIP, nama, atau jenis izin..."
                                class="w-full bg-transparent outline-none text-sm font-medium text-slate-700 placeholder-slate-400">
                        </div>
                    </form>
                </div>

                {{-- TABLE --}}
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200/80 min-h-[500px] animate-card delay-200">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">

                            <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-4 w-12 text-center">
                                        <input type="checkbox" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    </th>
                                    <th class="px-4 py-4 text-left font-semibold">NIP</th>
                                    <th class="px-4 py-4 text-left font-semibold">Nama</th>
                                    <th class="px-4 py-4 text-left font-semibold">Jenis Izin</th>
                                    <th class="px-4 py-4 text-left font-semibold">Tanggal</th>
                                    <th class="px-4 py-4 text-center font-semibold">Bukti File</th>
                                    <th class="px-4 py-4 text-center font-semibold">Status</th>
                                    <th class="px-4 py-4 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($perizinan as $p)
                                    <tr class="border-t border-slate-100 hover:bg-slate-50/70 transition duration-150 text-sm text-slate-700">

                                        <td class="px-4 py-4 text-center">
                                            <input type="checkbox" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                        </td>

                                        <td class="px-4 py-4 font-mono font-semibold uppercase text-slate-800">
                                            {{ $p->nip }}
                                        </td>

                                        <td class="px-4 py-4 font-semibold text-slate-800">
                                            {{ $p->nama }}
                                        </td>

                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                                @if($p->kategori == 'Sakit') bg-pink-50 text-pink-700 ring-1 ring-inset ring-pink-600/20
                                                @elseif($p->kategori == 'Cuti') bg-purple-50 text-purple-700 ring-1 ring-inset ring-purple-600/20
                                                @else bg-cyan-50 text-cyan-700 ring-1 ring-inset ring-cyan-600/20 @endif">
                                                {{ $p->kategori }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-4 text-slate-500 font-mono text-xs">
                                            @if($p->tanggal_mulai && $p->tanggal_selesai)
                                                {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d-m-Y') }}
                                                @if($p->tanggal_mulai !== $p->tanggal_selesai)
                                                    <br><span class="text-slate-400">s/d</span><br>
                                                    {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d-m-Y') }}
                                                @endif
                                            @else
                                                {{ $p->created_at ? $p->created_at->format('d-m-Y') : '-' }}
                                            @endif
                                        </td>

                                        {{-- Kolom Bukti File --}}
                                        <td class="px-4 py-4 text-center">
                                            @if($p->file_tambahan)
                                                <a href="{{ asset('storage/' . $p->file_tambahan) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 font-semibold text-xs hover:bg-emerald-100 transition">
                                                    <i class="fa-solid fa-file-arrow-down text-xs"></i>
                                                    Lihat File
                                                </a>
                                            @else
                                                <span class="text-slate-400 text-xs font-medium">— Tidak ada —</span>
                                            @endif
                                        </td>

                                        {{-- Badge status --}}
                                        <td class="px-4 py-4 text-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                                @if($p->status == 'Disetujui') bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20
                                                @elseif($p->status == 'Ditolak') bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20
                                                @else bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20 @endif">
                                                {{ $p->status }}
                                            </span>
                                        </td>

                                        {{-- Tombol Detail → buka modal --}}
                                        <td class="px-4 py-4 text-center">
                                            <button
                                                type="button"
                                                onclick="openDetailModal(
                                                    '{{ addslashes($p->nip) }}',
                                                    '{{ addslashes($p->nama) }}',
                                                    '{{ addslashes($p->divisi) }}',
                                                    '{{ addslashes($p->jabatan) }}',
                                                    '{{ addslashes($p->kategori) }}',
                                                    '{{ $p->tanggal_mulai }}',
                                                    '{{ $p->tanggal_selesai }}',
                                                    '{{ $p->status }}',
                                                    '{{ $p->file_tambahan ? asset('storage/' . $p->file_tambahan) : '' }}',
                                                    '{{ addslashes(basename($p->file_tambahan ?? '')) }}'
                                                )"
                                                class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20 font-semibold text-xs hover:bg-blue-100 transition">
                                                <i class="fa-solid fa-circle-info mr-1 text-xs"></i>
                                                Detail
                                            </button>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="h-[400px] text-center text-slate-400 italic text-sm">
                                            Belum ada data perizinan masuk.
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

</body>

{{-- ============================================================ --}}
{{-- MODAL DETAIL PERIZINAN                                       --}}
{{-- Tampilkan info lengkap: jenis izin, durasi, file bukti       --}}
{{-- ============================================================ --}}
<div id="modalDetailPerizinan"
    class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-[9999] p-4"
    style="z-index: 9999;">

    <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

        {{-- Header modal --}}
        <div class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 flex items-center justify-between">
            <div>
                <p class="text-xxs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Detail Pengajuan</p>
                <h2 class="text-base font-bold text-slate-800 tracking-tight">Informasi Perizinan</h2>
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
                </div>
            </div>

            {{-- Info Izin --}}
            <div class="bg-blue-50/60 rounded-xl p-4 border border-blue-100">
                <p class="text-xxs font-bold text-blue-400 uppercase tracking-wider mb-3">Detail Izin</p>
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

                {{-- Durasi --}}
                <div class="mt-3 pt-3 border-t border-blue-100">
                    <p class="text-xs text-slate-400 mb-0.5">Durasi</p>
                    <p id="detail_durasi" class="font-bold text-blue-700 text-sm"></p>
                </div>
            </div>

            {{-- Bukti File --}}
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60">
                <p class="text-xxs font-bold text-slate-400 uppercase tracking-wider mb-3">Bukti / Lampiran</p>

                <div id="detail_file_wrapper">
                    {{-- Diisi JS --}}
                </div>
            </div>

        </div>

        {{-- Footer modal --}}
        <div class="bg-slate-50 border-t border-slate-200/80 px-6 py-4 flex justify-end">
            <button type="button" onclick="closeDetailModal()"
                class="bg-white border border-slate-200 text-slate-700 px-5 py-2 rounded-xl font-semibold text-sm hover:bg-slate-50 transition shadow-sm">
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
    function openDetailModal(nip, nama, divisi, jabatan, kategori, tglMulai, tglSelesai, status, fileUrl, fileName) {
        // --- Identitas Karyawan ---
        document.getElementById('detail_nip').textContent     = nip    || '-';
        document.getElementById('detail_nama').textContent    = nama   || '-';
        document.getElementById('detail_divisi').textContent  = divisi || '-';
        document.getElementById('detail_jabatan').textContent = jabatan || '-';

        // --- Badge Jenis Izin ---
        const kategoriBadge = document.getElementById('detail_kategori_badge');
        kategoriBadge.textContent = kategori || '-';
        kategoriBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold ';
        if (kategori === 'Sakit')     kategoriBadge.className += 'bg-pink-100 text-pink-700';
        else if (kategori === 'Cuti') kategoriBadge.className += 'bg-purple-100 text-purple-700';
        else                          kategoriBadge.className += 'bg-cyan-100 text-cyan-700';

        // --- Badge Status ---
        const statusBadge = document.getElementById('detail_status_badge');
        statusBadge.textContent = status || '-';
        statusBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold ';
        if (status === 'Disetujui')     statusBadge.className += 'bg-emerald-100 text-emerald-700';
        else if (status === 'Ditolak')  statusBadge.className += 'bg-rose-100 text-rose-700';
        else                            statusBadge.className += 'bg-amber-100 text-amber-700';

        // --- Tanggal & Durasi ---
        const formatTgl = (tgl) => {
            if (!tgl) return '-';
            const d = new Date(tgl);
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
        };

        document.getElementById('detail_tgl_mulai').textContent   = formatTgl(tglMulai);
        document.getElementById('detail_tgl_selesai').textContent  = formatTgl(tglSelesai);

        // Hitung durasi hari
        let durasiText = '-';
        if (tglMulai && tglSelesai) {
            const mulai   = new Date(tglMulai);
            const selesai = new Date(tglSelesai);
            const diffMs  = selesai - mulai;
            const diffHari = Math.round(diffMs / (1000 * 60 * 60 * 24)) + 1; // inklusif
            durasiText = diffHari + (diffHari === 1 ? ' hari' : ' hari');
        }
        document.getElementById('detail_durasi').textContent = durasiText;

        // --- Bukti File ---
        const fileWrapper = document.getElementById('detail_file_wrapper');
        if (fileUrl && fileUrl !== '') {
            // Deteksi tipe file dari ekstensi nama file
            const ext = fileName.split('.').pop().toLowerCase();
            const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext);
            const isPdf   = ext === 'pdf';

            let fileHtml = '';

            if (isImage) {
                // Tampilkan preview gambar
                fileHtml = `
                    <div class="mb-3 rounded-xl overflow-hidden border border-slate-200 bg-slate-100">
                        <img src="${fileUrl}" alt="Bukti Izin"
                            class="w-full max-h-48 object-contain p-2"
                            onerror="this.parentElement.innerHTML='<p class=\\'text-xs text-slate-400 text-center py-6\\'>Gagal memuat gambar</p>'">
                    </div>
                `;
            } else if (isPdf) {
                // Tampilkan ikon PDF
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
                // File lainnya (docx, dll)
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

            // Tombol buka file di tab baru
            fileHtml += `
                <a href="${fileUrl}" target="_blank"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm transition shadow-sm">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    Buka File
                </a>
            `;

            fileWrapper.innerHTML = fileHtml;
        } else {
            // Tidak ada file
            fileWrapper.innerHTML = `
                <div class="flex flex-col items-center justify-center py-6 text-slate-400">
                    <i class="fa-solid fa-file-circle-xmark text-3xl mb-2 text-slate-300"></i>
                    <p class="text-sm font-medium">Tidak ada file yang dilampirkan</p>
                </div>
            `;
        }

        // Tampilkan modal
        const modal = document.getElementById('modalDetailPerizinan');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // Tutup modal
    function closeDetailModal() {
        const modal = document.getElementById('modalDetailPerizinan');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Tutup modal klik backdrop
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('modalDetailPerizinan');
        if (modal && e.target === modal) closeDetailModal();
    });

    // Tutup modal dengan ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDetailModal();
    });
</script>

</html>
