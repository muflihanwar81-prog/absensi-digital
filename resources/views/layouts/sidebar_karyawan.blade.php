<aside class="w-64 bg-[#efefef] border-r border-gray-400 flex flex-col justify-between">

    <div>

        <div class="px-6 py-5 border-b border-gray-300">
            <h1 class="text-2xl font-bold text-gray-800">CODIA</h1>
        </div>

        <nav class="p-4 space-y-2">

            <a
                href="{{ url('/dashboard_karyawan') }}"
                class="flex items-center gap-3 px-4 py-3 rounded font-semibold text-gray-800
                {{ request()->is('dashboard_karyawan') ? 'bg-gray-300' : 'hover:bg-gray-300' }}">
                Dashboard
            </a>

            <a
                href="{{ url('/karyawan_absen') }}"
                class="flex items-center gap-3 px-4 py-3 rounded font-semibold text-gray-800
                {{ request()->is('karyawan_absen') ? 'bg-gray-300' : 'hover:bg-gray-300' }}">
                Data Kehadiran
            </a>

            <a
                href="{{ url('/izin') }}"
                class="flex items-center gap-3 px-4 py-3 rounded font-semibold text-gray-800
                {{ request()->is('izin') ? 'bg-gray-300' : 'hover:bg-gray-300' }}">
                Pengajuan Izin
            </a>

        </nav>
    </div>

    <div class="p-4 border-t border-gray-300">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-full bg-gray-400 flex items-center justify-center font-bold text-sm text-white">
                {{ strtoupper(substr(session('karyawan_nama', 'Karyawan'), 0, 2)) }}
            </div>

            <div>
                <p class="font-bold text-sm">
                    {{ session('karyawan_nama', 'Karyawan') }}
                </p>
                <p class="text-xs text-gray-600">
                    Karyawan
                </p>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit"
                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded font-semibold">
                Logout
            </button>
        </form>
    </div>

</aside>