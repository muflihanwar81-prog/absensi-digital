<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Karyawan - Dashboard Admin</title>
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

    @include('layouts.sidebar')

    <main class="flex-1 h-screen overflow-y-auto">
       @include('components.header_admin')

        <div class="p-6">
            <div class="w-full mx-auto px-4 lg:px-6">

                {{-- HEADER CARD --}}
                <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm border border-slate-200/80">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                                Data Karyawan
                            </h1>
                            <p class="text-slate-500 text-sm mt-1">Kelola data lengkap karyawan, divisi, dan status akun pengguna.</p>
                        </div>

                        <button onclick="openModal()"
                            class="bg-blue-600 hover:bg-blue-700 text-white shadow-sm shadow-blue-500/10 px-5 py-2.5 rounded-xl font-semibold text-sm flex items-center gap-2 hover:scale-[1.02] transition-all duration-200">
                            <span class="text-lg leading-none">+</span>
                            <span>Tambah Karyawan</span>
                        </button>
                    </div>

                    {{-- STATISTIK DIVISI --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 text-gray-800">
                        @forelse($daftarDivisi as $divisi)
                        <div class="text-center bg-slate-50 border border-slate-200/60 rounded-xl py-3 shadow-sm hover:scale-[1.02] transition-transform duration-200">
                            <p class="text-xxs font-bold uppercase mb-1 text-slate-400 tracking-wider">
                                {{ $divisi }}
                            </p>
                            <h2 class="text-2xl font-extrabold text-slate-800 font-mono">
                                {{ \App\Models\Karyawan::where('divisi', $divisi)->count() }}
                            </h2>
                        </div>
                        @empty
                        <div class="col-span-4 text-center text-gray-500 italic py-8">
                            Belum ada data divisi
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- SEARCH & FILTER --}}
                <div class="flex gap-4 items-center mb-6">
                    <form action="{{ route('admin.karyawan') }}"
                        method="GET"
                        class="flex-1 flex flex-wrap gap-4 items-center">

                        {{-- SEARCH --}}
                        <div class="flex-1 min-w-[280px]">
                            <div class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 flex items-center gap-3 shadow-sm focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all duration-200">
                                <i class="fa-solid fa-magnifying-glass text-slate-400 text-base"></i>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari NIP dan nama karyawan..."
                                    class="w-full bg-transparent outline-none text-sm text-slate-700 placeholder-slate-400 font-medium">
                            </div>
                        </div>

                        {{-- FILTER DIVISI --}}
                        <select
                            name="divisi"
                            onchange="this.form.submit()"
                            class="bg-white border border-slate-200 shadow-sm px-4 py-2.5 rounded-xl font-semibold text-sm outline-none text-slate-700 cursor-pointer focus:border-blue-500 transition">
                            <option value="">Semua Divisi</option>
                            @foreach($daftarDivisi as $divisi)
                            <option value="{{ $divisi }}"
                                {{ request('divisi') == $divisi ? 'selected' : '' }}>
                                {{ $divisi }}
                            </option>
                            @endforeach
                        </select>

                        {{-- FILTER JABATAN --}}
                        <select
                            name="jabatan"
                            onchange="this.form.submit()"
                            class="bg-white border border-slate-200 shadow-sm px-4 py-2.5 rounded-xl font-semibold text-sm outline-none text-slate-700 cursor-pointer focus:border-blue-500 transition">
                            <option value="">Semua Jabatan</option>
                            @foreach(\App\Models\Karyawan::select('jabatan')->distinct()->pluck('jabatan') as $jabatan)
                            <option value="{{ $jabatan }}"
                                {{ request('jabatan') == $jabatan ? 'selected' : '' }}>
                                {{ $jabatan }}
                            </option>
                            @endforeach
                        </select>

                        {{-- FILTER STATUS --}}
                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="bg-white border border-slate-200 shadow-sm px-4 py-2.5 rounded-xl font-semibold text-sm outline-none text-slate-700 cursor-pointer focus:border-blue-500 transition">
                            <option value="">Semua Status</option>
                            <option value="Aktif"
                                {{ request('status') == 'Aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="Nonaktif"
                                {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>
                    </form>
                </div>

                {{-- TABEL --}}
                <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden min-h-[480px] shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-4 text-left font-semibold">No</th>
                                    <th class="px-4 py-4 text-left font-semibold">NIP</th>
                                    <th class="px-4 py-4 text-left font-semibold">Nama Karyawan</th>
                                    <th class="px-4 py-4 text-left font-semibold">Divisi</th>
                                    <th class="px-4 py-4 text-left font-semibold">Jabatan</th>
                                    <th class="px-4 py-4 text-left font-semibold">Jenis Kelamin</th>
                                    <th class="px-4 py-4 text-left font-semibold">Status</th>
                                    <th class="px-4 py-4 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($karyawans as $index => $k)
                                <tr class="border-t border-slate-100 hover:bg-slate-50/70 text-slate-700 text-sm transition duration-150">
                                    <td class="px-4 py-4 font-medium text-slate-500 font-mono">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4 font-semibold text-slate-800 font-mono">{{ $k->nip }}</td>
                                    <td class="px-4 py-4 font-semibold text-slate-800">{{ $k->nama }}</td>
                                    <td class="px-4 py-4">{{ $k->divisi }}</td>
                                    <td class="px-4 py-4">{{ $k->jabatan }}</td>
                                    <td class="px-4 py-4 text-slate-600">{{ $k->jenis_kelamin ?? '-' }}</td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                            {{ $k->status == 'Aktif'
                                                ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20'
                                                : 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20' }}">
                                            {{ $k->status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        <div class="flex justify-center gap-3.5 text-base">

                                            <a href="#" class="text-slate-400 hover:text-blue-600 transition" title="Foto Presensi">
                                                <i class="fa-solid fa-camera"></i>
                                            </a>

                                            {{-- TOMBOL DETAIL --}}
                                            <button type="button"
                                                onclick="openDetailModal(
                                                    '{{ $k->nip }}',
                                                    '{{ addslashes($k->nama) }}',
                                                    '{{ $k->divisi }}',
                                                    '{{ addslashes($k->jabatan) }}',
                                                    '{{ $k->tgl_lahir }}',
                                                    '{{ $k->jenis_kelamin }}',
                                                    '{{ addslashes($k->alamat) }}',
                                                    '{{ $k->username }}',
                                                    '{{ $k->tgl_bergabung }}',
                                                    '{{ $k->email }}',
                                                    '{{ $k->no_hp }}',
                                                    '{{ $k->role }}',
                                                    '{{ $k->status }}',
                                                    '{{ addslashes($k->komentar_nonaktif) }}'
                                                )"
                                                class="text-blue-600 hover:text-blue-750 transition"
                                                title="Lihat Detail">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </button>

                                            {{-- TOMBOL EDIT --}}
                                            <button type="button"
                                                onclick="openEditModal(
                                                    '{{ $k->id }}',
                                                    '{{ $k->nip }}',
                                                    '{{ addslashes($k->nama) }}',
                                                    '{{ $k->divisi }}',
                                                    '{{ addslashes($k->jabatan) }}',
                                                    '{{ $k->email }}',
                                                    '{{ $k->status }}',
                                                    '{{ $k->username }}',
                                                    '{{ $k->tgl_lahir }}',
                                                    '{{ $k->jenis_kelamin }}',
                                                    '{{ addslashes($k->alamat) }}',
                                                    '{{ $k->tgl_bergabung }}',
                                                    '{{ $k->no_hp }}',
                                                    '{{ $k->role }}',
                                                    '{{ addslashes($k->komentar_nonaktif) }}'
                                                )"
                                                class="text-blue-600 hover:text-blue-750 transition"
                                                title="Edit Data">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <form action="{{ route('admin.karyawan.destroy', $k->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="text-rose-500 hover:text-rose-600 transition"
                                                    title="Hapus Data">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8"
                                        class="h-[400px] text-center text-gray-400 italic text-xl">
                                        Belum ada data tersedia
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
    <!-- TAMBAHKAN INI SEBELUM TAG </body> -->
<!-- Jika modal ini tidak ada, fungsi openModal() tidak akan bekerja -->

{{-- MODAL TAMBAH KARYAWAN --}}
<div id="modalTambah"
     class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-50 p-4">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl border border-slate-200/80 relative flex flex-col max-h-[95vh]">

        <!-- Header -->
        <div class="bg-slate-50 border-b border-slate-200/80 rounded-t-2xl px-8 py-4.5 flex items-center justify-between flex-shrink-0">
            <h2 class="text-lg font-bold text-slate-800 tracking-tight">Form Tambah Data Karyawan &amp; Pengguna</h2>
            <button type="button" onclick="closeModal()"
                    class="text-slate-400 hover:text-slate-650 text-2xl font-bold leading-none">&times;</button>
        </div>

        <!-- Form Body -->
        <div class="overflow-y-auto px-8 py-6">
        <form id="formTambah" action="{{ route('admin.karyawan.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">

                {{-- KOLOM KIRI --}}

                <!-- NIK -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">NIK</label>
                    <input type="text" name="nip" required placeholder="Nomor Induk Karyawan"
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                </div>

                <!-- USERNAME -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Username</label>
                    <input type="text" name="username" placeholder="Username"
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                </div>

                <!-- NAMA KARYAWAN -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Nama Karyawan</label>
                    <input type="text" name="nama" required placeholder="Nama lengkap karyawan"
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="tambah_password" required placeholder="Mnimal 6 karakter"
                               class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-10 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                        <button type="button" onclick="togglePassword('tambah_password', 'tambah_eye')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i id="tambah_eye" class="fa-solid fa-eye-slash text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- DIVISI -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Divisi</label>
                    <div class="relative">
                        <select name="divisi" required
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm">
                            <option value="">Pilih Divisi</option>
                            @foreach($daftarDivisi as $divisi)
                                <option value="{{ $divisi }}">{{ $divisi }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
                    </div>
                </div>

                <!-- TGL BERGABUNG -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Tanggal Bergabung</label>
                    <div class="relative">
                        <input type="date" name="tgl_bergabung"
                               class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm text-slate-600">
                    </div>
                </div>

                <!-- JABATAN -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Jabatan</label>
                    <div class="relative">
                        <select name="jabatan" required
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm">
                            <option value="">Pilih Jabatan</option>
                            <option value="Karyawan">Karyawan</option>
                            <option value="Kepala Divisi">Kepala Divisi</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
                    </div>
                </div>

                <!-- G-MAIL -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Email</label>
                    <input type="email" name="email" 
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                </div>

                <!-- TGL LAHIR -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Tanggal Lahir</label>
                    <div class="relative">
                        <input type="date" name="tgl_lahir"
                               class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm text-slate-600">
                    </div>
                </div>

                <!-- NO HP -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Nomor Handphone</label>
                    <input type="text" name="no_hp" 
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                </div>

                <!-- JENIS KELAMIN -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Jenis Kelamin</label>
                    <div class="relative">
                        <select name="jenis_kelamin"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
                    </div>
                </div>

                <!-- ROLE -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Hak Akses</label>
                    <div class="relative">
                        <select name="role"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm">
                            <option value="">Pilih Role</option>
                            <option value="karyawan">karyawan</option>
                            <option value="kepala_divisi">kepala divisi</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
                    </div>
                </div>

                <!-- ALAMAT -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" placeholder="Tulis alamat rumah lengkap..."
                              class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none resize-none transition shadow-sm"></textarea>
                </div>

                <!-- STATUS -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Status Karyawan</label>
                    <div class="relative">
                        <select name="status" id="tambah_status" onchange="toggleKomentarTambah()"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
                    </div>
                </div>

                <!-- KOMENTAR NONAKTIF (TAMBAH) -->
                <div id="tambah_komentar_wrapper" class="md:col-span-2" style="display: none; overflow: hidden; transition: max-height 0.3s ease, opacity 0.3s ease; max-height: 0; opacity: 0;">
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                        <i class="fa-solid fa-comment-dots text-amber-500 mr-1"></i>Alasan / Komentar Nonaktif
                    </label>
                    <textarea name="komentar_nonaktif" id="tambah_komentar_nonaktif" rows="3" placeholder="Tuliskan alasan karyawan dinonaktifkan..."
                              class="w-full bg-amber-50/50 border border-amber-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none resize-none transition shadow-sm"></textarea>
                </div>

            </div>

            <!-- Tombol Simpan -->
            <div class="mt-6">
                <button type="submit"
                        class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl transition duration-200 shadow-sm shadow-blue-500/10 hover:shadow-blue-500/25">
                    Simpan
                </button>
            </div>
        </form>
        </div>
    </div>
</div>
{{-- MODAL EDIT KARYAWAN --}}
<div id="modalEdit"
     class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-50 p-4">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl border border-slate-200/80 relative flex flex-col max-h-[95vh]">

        <!-- Header -->
        <div class="bg-slate-50 border-b border-slate-200/80 rounded-t-2xl px-8 py-4.5 flex items-center justify-between flex-shrink-0">
            <h2 class="text-lg font-bold text-slate-800 tracking-tight">Data Karyawan &amp; Pengguna</h2>
            <button type="button" onclick="closeEditModal()"
                    class="text-slate-400 hover:text-slate-650 text-2xl font-bold leading-none">&times;</button>
        </div>

        <!-- Form Body -->
        <div class="overflow-y-auto px-8 py-6">
        <form id="formEdit" action="" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">

                <!-- NIP -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Nik</label>
                    <input type="text" id="edit_nip" name="nip" required
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                </div>

                <!-- USERNAME -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Username</label>
                    <input type="text" id="edit_username" name="username"
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                </div>

                <!-- NAMA -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Nama Karyawan</label>
                    <input type="text" id="edit_nama" name="nama" required
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="edit_password" placeholder="Kosongkan jika tidak ingin mengubah password"
                               class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-10 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                        <button type="button" onclick="togglePassword('edit_password', 'edit_eye')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i id="edit_eye" class="fa-solid fa-eye-slash text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- DIVISI -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Divisi</label>
                    <div class="relative">
                        <select id="edit_divisi" name="divisi" required
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm">
                            <option value="">Pilih Divisi</option>
                            @foreach($daftarDivisi as $divisi)
                                <option value="{{ $divisi }}">{{ $divisi }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
                    </div>
                </div>

                <!-- TGL BERGABUNG -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Tgl, Bergabung</label>
                    <input type="date" id="edit_tgl_bergabung" name="tgl_bergabung"
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm text-slate-650">
                </div>

                <!-- JABATAN -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Jabatan</label>
                    <div class="relative">
                        <select id="edit_jabatan" name="jabatan" required
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm">
                            <option value="Karyawan">Karyawan</option>
                            <option value="Kepala Divisi">Kepala Divisi</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
                    </div>
                </div>

                <!-- G-MAIL -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Email</label>
                    <input type="email" id="edit_email" name="email" required
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                </div>

                <!-- TGL LAHIR -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Tgl, Lahir</label>
                    <input type="date" id="edit_tgl_lahir" name="tgl_lahir"
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm text-slate-650">
                </div>

                <!-- NO HP -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">No Hp</label>
                    <input type="text" id="edit_no_hp" name="no_hp"
                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-150 shadow-sm">
                </div>

                <!-- JENIS KELAMIN -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Jenis Kelamin</label>
                    <div class="relative">
                        <select id="edit_jenis_kelamin" name="jenis_kelamin"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
                    </div>
                </div>

                <!-- ROLE -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Role</label>
                    <div class="relative">
                        <select id="edit_role" name="role"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm">
                            <option value="">Pilih Role</option>
                            <option value="karyawan">karyawan</option>
                            <option value="kepala_divisi">kepala divisi</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
                    </div>
                </div>

                <!-- ALAMAT -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Alamat lengkap</label>
                    <textarea id="edit_alamat" name="alamat" rows="2"
                              class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none resize-none transition shadow-sm"></textarea>
                </div>

                <!-- STATUS -->
                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">Status</label>
                    <div class="relative">
                        <select id="edit_status" name="status" onchange="toggleKomentarEdit()"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
                    </div>
                </div>

                <!-- KOMENTAR NONAKTIF (EDIT) -->
                <div id="edit_komentar_wrapper" class="md:col-span-2" style="display: none; overflow: hidden; transition: max-height 0.3s ease, opacity 0.3s ease; max-height: 0; opacity: 0;">
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                        <i class="fa-solid fa-comment-dots text-amber-500 mr-1"></i>Alasan / Komentar Nonaktif
                    </label>
                    <textarea name="komentar_nonaktif" id="edit_komentar_nonaktif" rows="3" placeholder="Tuliskan alasan karyawan dinonaktifkan..."
                              class="w-full bg-amber-50/50 border border-amber-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none resize-none transition shadow-sm"></textarea>
                </div>

            </div>

            <!-- Tombol Simpan -->
            <div class="mt-6">
                <button type="submit"
                        class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl transition duration-200 shadow-sm shadow-blue-500/10 hover:shadow-blue-500/25">
                    Simpan
                </button>
            </div>
        </form>
        </div>
    </div>
</div>
<script>
    
    // MODAL TAMBAH KARYAWAN
    
    function openModal() {
        const modalTambah = document.getElementById('modalTambah');
        if (modalTambah) {
            modalTambah.classList.remove('hidden');
            modalTambah.classList.add('flex');
        }
    }

    function closeModal() {
        const modalTambah = document.getElementById('modalTambah');
        if (modalTambah) {
            modalTambah.classList.add('hidden');
            modalTambah.classList.remove('flex');
        }
    }

    
    // MODAL EDIT KARYAWAN
    function openEditModal(id, nip, nama, divisi, jabatan, email, status, username, tglLahir, jenisKelamin, alamat, tglBergabung, noHp, role, komentarNonaktif) {
        document.getElementById('edit_nip').value       = nip       || '';
        document.getElementById('edit_nama').value      = nama      || '';
        document.getElementById('edit_jabatan').value   = jabatan   || '';
        document.getElementById('edit_email').value     = email     || '';
        document.getElementById('edit_username').value  = username  || '';
        document.getElementById('edit_tgl_lahir').value = tglLahir  || '';
        document.getElementById('edit_alamat').value    = alamat    || '';
        document.getElementById('edit_tgl_bergabung').value = tglBergabung || '';
        document.getElementById('edit_no_hp').value     = noHp      || '';

        // Divisi dropdown
        const editDivisi = document.getElementById('edit_divisi');
        if (editDivisi) {
            for (let o of editDivisi.options) o.selected = (o.value === divisi);
        }

        // Status dropdown
        const editStatus = document.getElementById('edit_status');
        if (editStatus) {
            for (let o of editStatus.options) o.selected = (o.value === (status || 'Aktif'));
        }

        // Jenis Kelamin dropdown
        const editJK = document.getElementById('edit_jenis_kelamin');
        if (editJK) {
            for (let o of editJK.options) o.selected = (o.value === jenisKelamin);
        }

        // Role dropdown
        const editRole = document.getElementById('edit_role');
        if (editRole) {
            for (let o of editRole.options) o.selected = (o.value === role);
        }

        // Komentar Nonaktif
        document.getElementById('edit_komentar_nonaktif').value = komentarNonaktif || '';
        toggleKomentarEdit();

        // Set action form update
        document.getElementById('formEdit').action = '/karyawan/' + id;

        
        // Show modal edit
        const modalEdit = document.getElementById('modalEdit');
        if (modalEdit) {
            modalEdit.classList.remove('hidden');
            modalEdit.classList.add('flex');
        }
    }

    function closeEditModal() {
        const modalEdit = document.getElementById('modalEdit');
        if (modalEdit) {
            modalEdit.classList.add('hidden');
            modalEdit.classList.remove('flex');
        }
    }

    // Toggle password visibility
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        }
    }

    // Tutup modal saat klik area gelap
    document.addEventListener('click', function (e) {
        const modalTambah = document.getElementById('modalTambah');
        const modalEdit   = document.getElementById('modalEdit');
        if (modalTambah && e.target === modalTambah) closeModal();
        if (modalEdit   && e.target === modalEdit)   closeEditModal();
    });

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { closeModal(); closeEditModal(); closeDetailModal(); }
    });

    
    // MODAL DETAIL KARYAWAN
    
    function openDetailModal(nip, nama, divisi, jabatan, tglLahir, jenisKelamin, alamat, username, tglBergabung, email, noHp, role, status, komentarNonaktif) {
        document.getElementById('detail_nip').textContent           = nip           || '-';
        document.getElementById('detail_nama').textContent          = nama          || '-';
        document.getElementById('detail_divisi').textContent        = divisi        || '-';
        document.getElementById('detail_jabatan').textContent       = jabatan       || '-';
        document.getElementById('detail_tgl_lahir').textContent     = tglLahir      || '-';
        document.getElementById('detail_jenis_kelamin').textContent = jenisKelamin  || '-';
        document.getElementById('detail_alamat').textContent        = alamat        || '-';
        document.getElementById('detail_username').textContent      = username      || '-';
        document.getElementById('detail_tgl_bergabung').textContent = tglBergabung  || '-';
        document.getElementById('detail_email').textContent         = email         || '-';
        document.getElementById('detail_no_hp').textContent         = noHp          || '-';
        document.getElementById('detail_role').textContent          = role          || '-';
        document.getElementById('detail_status').textContent        = status        || '-';

        // Komentar Nonaktif
        const komentarWrapper = document.getElementById('detail_komentar_wrapper');
        const komentarText = document.getElementById('detail_komentar_nonaktif');
        if (status === 'Nonaktif' && komentarNonaktif) {
            komentarText.textContent = komentarNonaktif;
            komentarWrapper.style.display = 'block';
        } else {
            komentarWrapper.style.display = 'none';
            komentarText.textContent = '-';
        }

        const modalDetail = document.getElementById('modalDetail');
        if (modalDetail) {
            modalDetail.classList.remove('hidden');
            modalDetail.classList.add('flex');
        }
    }

    function closeDetailModal() {
        const modalDetail = document.getElementById('modalDetail');
        if (modalDetail) {
            modalDetail.classList.add('hidden');
            modalDetail.classList.remove('flex');
        }
    }

    // Tutup modal detail saat klik backdrop
    document.addEventListener('click', function (e) {
        const modalDetail = document.getElementById('modalDetail');
        if (modalDetail && e.target === modalDetail) closeDetailModal();
    });

    // Toggle komentar nonaktif visibility - TAMBAH modal
    function toggleKomentarTambah() {
        const status = document.getElementById('tambah_status').value;
        const wrapper = document.getElementById('tambah_komentar_wrapper');
        if (status === 'Nonaktif') {
            wrapper.style.display = 'block';
            requestAnimationFrame(() => {
                wrapper.style.maxHeight = '200px';
                wrapper.style.opacity = '1';
            });
        } else {
            wrapper.style.maxHeight = '0';
            wrapper.style.opacity = '0';
            setTimeout(() => { wrapper.style.display = 'none'; }, 300);
            document.getElementById('tambah_komentar_nonaktif').value = '';
        }
    }

    // Toggle komentar nonaktif visibility - EDIT modal
    function toggleKomentarEdit() {
        const status = document.getElementById('edit_status').value;
        const wrapper = document.getElementById('edit_komentar_wrapper');
        if (status === 'Nonaktif') {
            wrapper.style.display = 'block';
            requestAnimationFrame(() => {
                wrapper.style.maxHeight = '200px';
                wrapper.style.opacity = '1';
            });
        } else {
            wrapper.style.maxHeight = '0';
            wrapper.style.opacity = '0';
            setTimeout(() => { wrapper.style.display = 'none'; }, 300);
            document.getElementById('edit_komentar_nonaktif').value = '';
        }
    }
</script>

{{-- MODAL DETAIL KARYAWAN --}}
<div id="modalDetail"
     class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-50 p-4">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl border border-slate-200/80 relative flex flex-col max-h-[95vh]">

        <!-- Header -->
        <div class="bg-slate-50 border-b border-slate-200/80 rounded-t-2xl px-8 py-4.5 flex items-center justify-between flex-shrink-0">
            <h2 class="text-lg font-bold text-slate-800 tracking-tight">Detail Karyawan</h2>
            <button type="button" onclick="closeDetailModal()"
                    class="text-slate-400 hover:text-slate-650 text-2xl font-bold leading-none">&times;</button>
        </div>

        <!-- Detail Body -->
        <div class="overflow-y-auto px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">NIK</label>
                    <p id="detail_nip" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">Username</label>
                    <p id="detail_username" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">Nama Karyawan</label>
                    <p id="detail_nama" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">Email</label>
                    <p id="detail_email" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">Divisi</label>
                    <p id="detail_divisi" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">Jabatan</label>
                    <p id="detail_jabatan" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">Tanggal Lahir</label>
                    <p id="detail_tgl_lahir" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">Jenis Kelamin</label>
                    <p id="detail_jenis_kelamin" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">Tanggal Bergabung</label>
                    <p id="detail_tgl_bergabung" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">No HP</label>
                    <p id="detail_no_hp" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">Role</label>
                    <p id="detail_role" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div>
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">Status</label>
                    <p id="detail_status" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1 font-bold text-slate-400 text-xxs uppercase tracking-wider">Alamat</label>
                    <p id="detail_alamat" class="text-sm font-semibold text-slate-800">-</p>
                </div>

                <!-- KOMENTAR NONAKTIF (DETAIL) -->
                <div id="detail_komentar_wrapper" class="md:col-span-2" style="display: none;">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mt-1">
                        <label class="block mb-1.5 font-bold text-amber-600 text-xxs uppercase tracking-wider">
                            <i class="fa-solid fa-triangle-exclamation mr-1"></i>Alasan Nonaktif
                        </label>
                        <p id="detail_komentar_nonaktif" class="text-sm font-medium text-amber-800">-</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>