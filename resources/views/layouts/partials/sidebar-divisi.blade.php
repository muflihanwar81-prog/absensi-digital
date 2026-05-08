<aside class="w-64 h-screen bg-white border-r border-gray-200 flex flex-col justify-between shadow-sm">
    <div>
        <div class="p-8 mb-4">
            <div class="h-8"></div> </div>

        <nav>
            <ul class="text-sm font-bold">
                <li class="{{ Request::is('divisi/dashboard*') ? 'bg-gray-200 border-r-4 border-black' : '' }}">
                    <a href="/divisi/dashboard" class="block px-8 py-4 text-gray-800">
                        Dashboard
                    </a>
                </li>
                
                <li class="{{ Request::is('divisi/absensi*') ? 'bg-gray-200 border-r-4 border-black' : '' }}">
                    <a href="#" class="block px-8 py-4 text-gray-800 hover:bg-gray-50 transition">
                        Data Absensi
                    </a>
                </li>

                <li class="{{ Request::is('divisi/izin*') ? 'bg-gray-200 border-r-4 border-black' : '' }}">
                    <a href="#" class="block px-8 py-4 text-gray-800 hover:bg-gray-50 transition">
                        Pengajuan Izin
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="p-6">
        <div class="w-14 h-14 bg-gray-300 rounded-full flex items-center justify-center font-black text-xl shadow-inner border border-gray-400">
            DK
        </div>
    </div>
</aside>