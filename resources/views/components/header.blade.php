<div class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm">
    <div class="flex items-center justify-between px-8 py-4">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-slate-800">
                CODIA-<span class="text-blue-500">SYNC</span>
            </h1>
        </div>

        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="text-xs text-slate-400 font-medium">Selamat Datang</p>
                <p class="text-sm font-bold text-slate-800">
                    {{ session('karyawan_nama', 'Karyawan') }}
                </p>
            </div>

            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/20 ring-2 ring-white/10">
                {{ strtoupper(substr(session('karyawan_nama', 'Karyawan'), 0, 1)) }}
            </div>
        </div>
    </div>
</div>