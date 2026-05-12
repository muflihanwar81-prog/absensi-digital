<div class="bg-white/90 backdrop-blur-xl border-b border-blue-100 shadow-sm">
                <div class="flex items-center justify-between px-8 py-5">
                    <div>
                        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            CODIA-SYNC
                        </h1>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm text-slate-500">Selamat Datang</p>
                            <p class="font-bold text-slate-800">
                                Hallo, {{ session('karyawan_nama', 'Karyawan') }}
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold shadow-lg">
                            {{ strtoupper(substr(session('karyawan_nama', 'Karyawan'), 0, 1)) }}
                        </div>
                    </div>
                </div>
            </div>