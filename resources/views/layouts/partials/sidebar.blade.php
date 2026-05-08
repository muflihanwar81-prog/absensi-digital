<aside class="w-64 h-screen bg-blue-500 border-r border-gray-300 flex flex-col justify-between">
    <div>
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
            <span class="font-bold text-xl tracking-tight text-white">ADMIN</span>
        </div>
        <nav class="mt-2">
            <ul class="text-sm font-semibold">
                <li><a href="#" class="block px-8 py-3 text-white hover:bg-blue-600">Dashboard</a></li>
                <li class="{{ Route::is('admin.karyawan.*') ? 'bg-white text-blue-500 border-l-4 border-gray-600' : 'text-white hover:bg-blue-600' }}">
                    <a href="{{ route('admin.karyawan.index') }}" class="block px-8 py-3">Data Karyawan</a>
                </li>
                <li><a href="#" class="block px-8 py-3 text-white hover:bg-blue-600">Kelola Divisi</a></li>
                <li class="{{ Route::is('admin.absensi.*') ? 'bg-white text-blue-500 border-l-4 border-gray-600' : 'text-white hover:bg-blue-600' }}">
                    <a href="{{ route('admin.absensi.index') }}" class="block px-8 py-3">Data Absensi</a>
                </li>
                <li class="{{ Route::is('admin.perizinan.*') ? 'bg-white text-blue-500 border-l-4 border-gray-600' : 'text-white hover:bg-blue-600' }}">
                    <a href="{{ route('admin.perizinan.index') }}" class="block px-8 py-3">Data Perizinan</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="p-4">
        <div class="bg-gray-300 py-3 px-6 font-bold text-lg rounded-sm text-center w-full">DK</div>
    </div>
</aside>