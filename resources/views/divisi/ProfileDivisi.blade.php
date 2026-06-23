<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kepala Divisi - CODIA SYNC</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        @keyframes scaleUp {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .animate-scale-up {
            animation: scaleUp 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 font-sans selection:bg-blue-600 selection:text-white">

    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        @include('layouts.partials.sidebar-divisi')
        
        {{-- MAIN CONTENT --}}
        <main id="mainContent" class="flex-1 transition-all duration-300">
            {{-- TOP HEADER --}}
            @include('components.header')
            
            {{-- CONTENT (MEMENUHI LAYAR) --}}
            <div class="p-6 w-full">
                {{-- TITLE SECTION --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 mb-6 flex items-center justify-between hover:shadow-md transition-shadow duration-300">
                    <div>
                        <p class="text-blue-600 font-semibold mb-1 uppercase tracking-wider text-xs">
                            Informasi Manajemen
                        </p>
                        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                            Data Profil Kepala Divisi
                        </h2>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-user-tie text-lg"></i>
                    </div>
                </div>

                {{-- FLASH MESSAGES & VALIDATION ERRORS --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm font-semibold shadow-sm flex items-center gap-2">
                        <span>✅</span> <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-700 text-sm font-semibold shadow-sm flex items-center gap-2">
                        <span>❌</span> <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-700 text-sm font-semibold shadow-sm">
                        <div class="flex items-center gap-2 mb-2 font-bold">
                            <span>⚠️</span> <span>Terjadi kesalahan input:</span>
                        </div>
                        <ul class="list-disc pl-6 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- PROFILE MAIN CARD --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-8 mb-6 text-center hover:shadow-md transition-shadow duration-300">
                    <div class="flex flex-col items-center">
                        {{-- Avatar Initials --}}
                        @php
                            $namaParts = explode(' ', $kepalaDivisi->nama);
                            $initials = '';
                            foreach (array_slice($namaParts, 0, 3) as $part) {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                        @endphp
                        <div class="w-28 h-28 rounded-full bg-gradient-to-tr from-blue-700 to-indigo-700 flex items-center justify-center text-3xl font-extrabold text-white shadow-lg ring-4 ring-blue-50 mb-4">
                            {{ $initials ?: 'KD' }}
                        </div>

                        {{-- Name & Email --}}
                        <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                            {{ $kepalaDivisi->nama }}
                        </h3>
                        <p class="text-slate-500 font-medium text-sm mt-1 hover:text-blue-600 transition-colors">
                            <a href="mailto:{{ $kepalaDivisi->email }}">{{ $kepalaDivisi->email }}</a>
                        </p>
                        
                        {{-- Action Buttons --}}
                        <div class="flex gap-4 mt-6">
                            <button type="button" onclick="openEditModal()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-sm hover:scale-[1.02] transition-all duration-200">
                                <i class="fa-solid fa-user-pen mr-2"></i>Edit Profil
                            </button>
                            <button type="button" onclick="openPasswordModal()" class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-xl shadow-sm transition-all duration-200">
                                <i class="fa-solid fa-key mr-2"></i>Ubah Password
                            </button>
                        </div>
                    </div>
                </div>

                {{-- PROFILE DETAIL CARD --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <div class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Info Lengkap Kedivisian</h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            {{-- NIK --}}
                            <div class="flex items-start gap-4">
                                <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                    <i class="fa-solid fa-id-card"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold text-xxs uppercase tracking-wider">NIK</p>
                                    <p class="text-slate-800 font-semibold text-sm mt-0.5">{{ $kepalaDivisi->nip ?? '-' }}</p>
                                </div>
                            </div>
                            {{-- Username --}}
                            <div class="flex items-start gap-4">
                                <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                    <i class="fa-solid fa-user-tag"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold text-xxs uppercase tracking-wider">Username</p>
                                    <p class="text-slate-800 font-semibold text-sm mt-0.5">{{ $kepalaDivisi->username ?? '-' }}</p>
                                </div>
                            </div>
                            {{-- Nama --}}
                            <div class="flex items-start gap-4">
                                <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold text-xxs uppercase tracking-wider">Nama Kepala Divisi</p>
                                    <p class="text-slate-800 font-semibold text-sm mt-0.5">{{ $kepalaDivisi->nama }}</p>
                                </div>
                            </div>
                            {{-- Tanggal Jabatan --}}
                            <div class="flex items-start gap-4">
                                <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold text-xxs uppercase tracking-wider">Tgl_Bergabung</p>
                                    <p class="text-slate-800 font-semibold text-sm mt-0.5">
                                        {{ $kepalaDivisi->tgl_bergabung ? \Carbon\Carbon::parse($kepalaDivisi->tgl_bergabung)->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                            {{-- Divisi Terpimpin --}}
                            <div class="flex items-start gap-4">
                                <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold text-xxs uppercase tracking-wider">Memimpin Divisi</p>
                                    <p class="text-slate-800 font-semibold text-sm mt-0.5">
                                        {{ $kepalaDivisi->divisi->nama_divisi ?? $kepalaDivisi->divisi ?? '-' }}
                                    </p>
                                </div>
                            </div>
                            {{-- No Hp --}}
                            <div class="flex items-start gap-4">
                                <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold text-xxs uppercase tracking-wider">No Hp</p>
                                    <p class="text-slate-800 font-semibold text-sm mt-0.5">{{ $kepalaDivisi->no_hp ?? '-' }}</p>
                                </div>
                            </div>
                            {{-- Jabatan --}}
                            <div class="flex items-start gap-4">
                                <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold text-xxs uppercase tracking-wider">Jabatan</p>
                                    <p class="text-slate-800 font-semibold text-sm mt-0.5">{{ $kepalaDivisi->jabatan ?? 'Kepala Divisi' }}</p>
                                </div>
                            </div>
                            {{-- Tingkat Role --}}
                            <div class="flex items-start gap-4">
                                <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                    <i class="fa-solid fa-user-shield"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold text-xxs uppercase tracking-wider">Role</p>
                                    <p class="text-slate-800 font-semibold text-sm mt-0.5 uppercase tracking-wider text-blue-600">{{ $kepalaDivisi->role ?? 'kepala_divisi' }}</p>
                                </div>
                            </div>
                            {{-- Tgl Lahir --}}
                            <div class="flex items-start gap-4">
                                <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                    <i class="fa-solid fa-cake-candles"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold text-xxs uppercase tracking-wider">Tgl_Lahir</p>
                                    <p class="text-slate-800 font-semibold text-sm mt-0.5">
                                        {{ $kepalaDivisi->tgl_lahir ? \Carbon\Carbon::parse($kepalaDivisi->tgl_lahir)->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                            {{-- Status --}}
                            <div class="flex items-start gap-4">
                                <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                    <i class="fa-solid fa-circle-info"></i>
                                </div>
                                <div>
                                    <p class="text-slate-450 font-bold text-xxs uppercase tracking-wider">Status</p>
                                    <p class="text-slate-800 font-semibold text-sm mt-0.5">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                            {{ $kepalaDivisi->status ?? 'Aktif' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            {{-- Jenis Kelamin --}}
                            <div class="flex items-start gap-4">
                                <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                    <i class="fa-solid fa-venus-mars"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold text-xxs uppercase tracking-wider">Jenis Kelamin</p>
                                    <p class="text-slate-800 font-semibold text-sm mt-0.5">{{ $kepalaDivisi->jenis_kelamin ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Alamat --}}
                        <div class="border-t border-slate-100 mt-6 pt-6 flex items-start gap-4">
                            <div class="text-slate-400 mt-1 w-5 flex justify-center text-base shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <p class="text-slate-400 font-bold text-xxs uppercase tracking-wider">Alamat Lengkap Rumah</p>
                                <p class="text-slate-800 font-semibold text-sm mt-1 leading-relaxed">{{ $kepalaDivisi->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- MODAL EDIT PROFILE --}}
    <div id="editProfileModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-all duration-300">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-4xl overflow-hidden animate-scale-up">
            <div class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-user-pen"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Form Update Profil Kepala Divisi</h3>
                </div>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition-colors text-xl font-medium w-8 h-8 rounded-lg flex items-center justify-center hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            {{-- Sesuaikan nama route penampung update di backend Anda --}}
            <form action="{{ route('divisi.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="p-6 overflow-y-auto max-h-[70vh]">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                        {{-- KOLOM KIRI --}}
                        <div class="space-y-4">
                            <div>
                                <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">NIK</label>
                                <input type="text" value="{{ $kepalaDivisi->nip }}" disabled class="w-full px-4 py-2.5 rounded-xl bg-slate-100 text-slate-500 border border-slate-200 cursor-not-allowed text-sm font-semibold">
                            </div>
                            <div>
                                <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Nama kepala divisi</label>
                                <input type="text" name="nama" value="{{ old('nama', $kepalaDivisi->nama) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white text-slate-800 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-semibold outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Memimpin Divisi</label>
                                <input type="text" value="{{ $kepalaDivisi->divisi->nama_divisi ?? $kepalaDivisi->divisi ?? '-' }}" disabled class="w-full px-4 py-2.5 rounded-xl bg-slate-100 text-slate-500 border border-slate-200 cursor-not-allowed text-sm font-semibold">
                            </div>
                            <div>
                                <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Jabatan</label>
                                <input type="text" value="{{ $kepalaDivisi->jabatan ?? 'Kepala Divisi' }}" disabled class="w-full px-4 py-2.5 rounded-xl bg-slate-100 text-slate-500 border border-slate-200 cursor-not-allowed text-sm font-semibold">
                            </div>
                            <div>
                                <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Tgl_Lahir</label>
                                <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', $kepalaDivisi->tgl_lahir) }}" class="w-full px-4 py-2.5 rounded-xl bg-white text-slate-800 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-semibold outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
                                <div class="relative">
                                    <select name="jenis_kelamin" class="w-full px-4 py-2.5 rounded-xl bg-white text-slate-800 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-semibold outline-none appearance-none">
                                        <option value="" disabled {{ is_null($kepalaDivisi->jenis_kelamin) ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $kepalaDivisi->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $kepalaDivisi->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="space-y-4 flex flex-col">
                            <div>
                                <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Username</label>
                                <input type="text" name="username" value="{{ old('username', $kepalaDivisi->username) }}" class="w-full px-4 py-2.5 rounded-xl bg-white text-slate-800 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-semibold outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Tgl_ Bergabung</label>
                                <input type="text" value="{{ $kepalaDivisi->tgl_bergabung ? \Carbon\Carbon::parse($kepalaDivisi->tgl_bergabung)->format('d/m/Y') : '-' }}" disabled class="w-full px-4 py-2.5 rounded-xl bg-slate-100 text-slate-500 border border-slate-200 cursor-not-allowed text-sm font-semibold">
                            </div>
                            <div>
                                <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">G.Mail</label>
                                <input type="email" name="email" value="{{ old('email', $kepalaDivisi->email) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white text-slate-800 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-semibold outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">No HP</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $kepalaDivisi->no_hp) }}" class="w-full px-4 py-2.5 rounded-xl bg-white text-slate-800 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-semibold outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Role</label>
                                <input type="text" value="{{ $kepalaDivisi->role ?? 'kepala_divisi' }}" disabled class="w-full px-4 py-2.5 rounded-xl bg-slate-100 text-slate-500 border border-slate-200 cursor-not-allowed text-sm font-semibold">
                            </div>
                            {{-- Status --}}
                            <div>
                                <label class="block text-slate-550 text-xs font-bold uppercase tracking-wider mb-1.5">Status</label>
                                <input type="text" value="{{ $kepalaDivisi->status ?? 'Aktif' }}" disabled class="w-full px-4 py-2.5 rounded-xl bg-slate-100 text-slate-500 border border-slate-200 cursor-not-allowed text-sm font-semibold">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-white text-slate-800 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-semibold outline-none resize-none">{{ old('alamat', $kepalaDivisi->alamat) }}</textarea>
                    </div>
                </div>
                
                <div class="bg-slate-50 border-t border-slate-200/80 px-6 py-4 flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold text-sm rounded-xl shadow-sm hover:bg-slate-50 transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-sm hover:scale-[1.01] transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL UBAH PASSWORD --}}
    <div id="passwordModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-all duration-300">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-md overflow-hidden animate-scale-up">
            <div class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Ubah Password Akun</h3>
                </div>
                <button type="button" onclick="closePasswordModal()" class="text-slate-400 hover:text-slate-600 transition-colors text-xl font-medium w-8 h-8 rounded-lg flex items-center justify-center hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            {{-- Sesuaikan nama route penampung ubah password di backend Anda --}}
            <form action="{{ route('divisi.profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Masukkan Password Lama:</label>
                        <div class="relative">
                            <input type="password" name="password_lama" required class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-white text-slate-800 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-semibold outline-none">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Masukkan Password Baru:</label>
                        <div class="relative">
                            <input type="password" name="password_baru" required class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-white text-slate-800 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-semibold outline-none">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="fa-solid fa-lock-open"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1.5">Konfirmasi Password Baru:</label>
                        <div class="relative">
                            <input type="password" name="password_baru_confirmation" required class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-white text-slate-800 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-semibold outline-none">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-50 border-t border-slate-200/80 px-6 py-4 flex justify-end gap-3">
                    <button type="button" onclick="closePasswordModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold text-sm rounded-xl shadow-sm hover:bg-slate-50 transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-sm hover:scale-[1.01] transition-all">Simpan Password</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL SCRIPTS --}}
    <script>
        function openEditModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeEditModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        function openPasswordModal() {
            document.getElementById('passwordModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal when clicking backdrop
        window.addEventListener('click', function(e) {
            const editModal = document.getElementById('editProfileModal');
            const passwordModal = document.getElementById('passwordModal');
            
            if (e.target === editModal) {
                closeEditModal();
            }
            if (e.target === passwordModal) {
                closePasswordModal();
            }
        });
    </script>
</body>

</html>