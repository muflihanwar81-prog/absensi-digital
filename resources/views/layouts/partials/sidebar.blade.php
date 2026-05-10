<aside id="sidebar"
    class="w-64 bg-[#efefef] flex flex-col justify-between border-r transition-all duration-300 h-screen shrink-0">

    <div>
        <!-- Header -->
        <div class="p-5 flex items-center justify-between">
            <h1 id="sidebarTitle" class="text-2xl font-bold text-gray-700 whitespace-nowrap">
                CODIA
            </h1>

            <button onclick="toggleSidebar()"
                class="bg-gray-300 p-2 rounded-lg hover:bg-gray-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Menu -->
        <ul class="space-y-2 px-4">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->is('dashboard') ? 'bg-gray-300 font-semibold' : 'hover:bg-gray-300' }}">
                    <span class="text-xl">🏠</span>
                    <span class="menu-text whitespace-nowrap">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.karyawan') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->is('karyawan*') ? 'bg-gray-300 font-semibold' : 'hover:bg-gray-300' }}">
                    <span class="text-xl">👨‍💼</span>
                    <span class="menu-text whitespace-nowrap">Data Karyawan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.keloladivisi') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->is('keloladivisi*') ? 'bg-gray-300 font-semibold' : 'hover:bg-gray-300' }}">
                    <span class="text-xl">🏢</span>
                    <span class="menu-text whitespace-nowrap">Kelola Divisi</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.absensi.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->is('absensi*') ? 'bg-gray-300 font-semibold' : 'hover:bg-gray-300' }}">
                    <span class="text-xl">📅</span>
                    <span class="menu-text whitespace-nowrap">Data Kehadiran</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.perizinan.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->is('perizinan*') ? 'bg-gray-300 font-semibold' : 'hover:bg-gray-300' }}">
                    <span class="text-xl">📄</span>
                    <span class="menu-text whitespace-nowrap">Data Perizinan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.laporan') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->is('laporan') ? 'bg-gray-300 font-semibold' : 'hover:bg-gray-300' }}">
                    <span class="text-xl">📊</span>
                    <span class="menu-text whitespace-nowrap">Laporan</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="p-4 bg-gray-300">
        <div class="text-xl font-bold flex items-center gap-3 mb-3">
            <span>👤</span>
            <span class="menu-text whitespace-nowrap">DK</span>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-red-500 text-white hover:bg-red-600 transition">
                <span>🚪</span>
                <span class="menu-text whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>
</aside>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const texts = document.querySelectorAll('.menu-text');
    const title = document.getElementById('sidebarTitle');

    const isCollapsed = sidebar.classList.contains('w-24');

    if (isCollapsed) {
        // Buka sidebar
        sidebar.classList.remove('w-24');
        sidebar.classList.add('w-64');

        texts.forEach(text => text.classList.remove('hidden'));
        title.classList.remove('hidden');
    } else {
        // Tutup sidebar
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-24');

        texts.forEach(text => text.classList.add('hidden'));
        title.classList.add('hidden');
    }
}
</script>