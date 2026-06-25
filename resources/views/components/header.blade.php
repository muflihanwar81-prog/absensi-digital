<div class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm">
    <div class="flex items-center justify-between px-8 py-4">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-slate-800">
                CODIA-<span class="text-blue-500">SYNC</span>
            </h1>
        </div>

        <div class="flex items-center gap-3 mb-3 px-2">
            
            <div class="menu-text min-w-0">
                <p class="font-bold text-black-100 text-sm truncate">
                    {{ session('karyawan_nama', 'Karyawan') }}
                </p>
                <p class="text-xs text-slate-450 truncate">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                    {{ $karyawan->status ?? 'Aktif' }}
                    </span>
                </p>
            </div>
            <a href="{{ url('/profile') }}"
            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-white/10 group-hover:scale-105 transition-transform duration-200 shrink-0">
            {{ strtoupper(substr(session('karyawan_nama', 'Karyawan'), 0, 1)) }}
            
            </a>
        </div>
    </div>
</div>