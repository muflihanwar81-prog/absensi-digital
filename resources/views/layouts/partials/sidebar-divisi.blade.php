<aside class="w-64 bg-blue-500 flex flex-col shadow-lg min-h-screen">
    <div class="p-6">
        <nav class="space-y-2 text-sm font-semibold">
            <a href="{{ route('divisi.dashboard') }}" 
               class="block px-4 py-3 {{ request()->routeIs('divisi.dashboard') ? 'bg-gray-300' : 'hover:bg-gray-100' }} rounded transition">
               Dashboard
            </a>
            <a href="{{ route('divisi.karyawan') }}" class="block px-4 py-3 {{ request()->routeIs('divisi.karyawan') ? 'bg-gray-300' : 'hover:bg-gray-100' }} rounded transition">Data Karyawan</a>
            <a href="{{ route('divisi.riwayat-absensi') }}" 
                class="block px-4 py-3 {{ request()->routeIs('divisi.riwayat-absensi') ? 'bg-gray-300' : 'hover:bg-gray-100' }} rounded transition text-sm font-semibold">
                Riwayat Absensi
            </a>
            <a href="{{ route('divisi.data-perizinan') }}" class="block px-4 py-3 {{ request()->routeIs('divisi.data-perizinan') ? 'bg-gray-300' : 'hover:bg-gray-100' }} rounded transition">Data Perizinan</a>
            <a href="{{ route('divisi.laporan') }}" class="block px-4 py-3 {{ request()->routeIs('divisi.laporan') ? 'bg-gray-300' : 'hover:bg-gray-100' }} rounded transition">Laporan</a>
        </nav>
    </div>
    
    <div class="mt-auto p-4 border-t border-gray-100">
        <div class="bg-gray-800 text-white w-12 h-12 flex items-center justify-center rounded font-bold">
            DK
        </div>
    </div>
</aside>