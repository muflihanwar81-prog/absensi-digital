<aside id="sidebarKaryawan"
    class="w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white flex flex-col justify-between shadow-2xl border-r border-slate-700 transition-all duration-300 h-screen">

    {{-- HEADER --}}
    <div>
        <div class="p-5 border-b border-slate-700">
            <div class="flex items-center justify-between">
                <div id="sidebarTitle">
                    <h1 class="text-3xl font-extrabold tracking-tight mt-1">
                        CODIA
                    </h1>
                </div>

                <button onclick="toggleSidebarKaryawan()"
                    class="bg-slate-700/80 hover:bg-slate-600 p-2.5 rounded-xl transition duration-300 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 text-white"
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
        </div>

        {{-- NAVIGATION --}}
        <nav class="px-4 py-6">
            <ul class="space-y-2">

                {{-- DASHBOARD --}}
                <li>
                    <a href="{{ url('/dashboard_karyawan') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-300
                        {{ request()->is('dashboard_karyawan')
                            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl font-semibold'
                            : 'text-slate-200 hover:bg-slate-700/70 hover:text-white' }}">
                        <span class="text-2xl w-8 text-center">🏠</span>
                        <span class="menu-text font-medium">Dashboard</span>
                    </a>
                </li>

                {{-- DATA KEHADIRAN --}}
                <li>
                    <a href="{{ url('/karyawan_absen') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-300
                        {{ request()->is('karyawan_absen')
                            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl font-semibold'
                            : 'text-slate-200 hover:bg-slate-700/70 hover:text-white' }}">
                        <span class="text-2xl w-8 text-center">📅</span>
                        <span class="menu-text font-medium">Data Kehadiran</span>
                    </a>
                </li>

                {{-- PENGAJUAN IZIN --}}
                <li>
                    <a href="{{ url('/izin') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-300
                        {{ request()->is('izin')
                            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl font-semibold'
                            : 'text-slate-200 hover:bg-slate-700/70 hover:text-white' }}">
                        <span class="text-2xl w-8 text-center">📄</span>
                        <span class="menu-text font-medium">Pengajuan Izin</span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

    {{-- FOOTER PROFILE --}}
    <div class="p-4 border-t border-slate-700 bg-slate-800/70 backdrop-blur-sm">

        {{-- USER INFO --}}
        <div class="flex items-center gap-3 mb-4 px-2">
            <div
                class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                {{ strtoupper(substr(session('karyawan_nama', 'Karyawan'), 0, 2)) }}
            </div>

            <div class="menu-text">
                <p class="font-bold text-white truncate">
                    {{ session('karyawan_nama', 'Karyawan') }}
                </p>
                <p class="text-xs text-slate-400">
                    Karyawan Aktif
                </p>
            </div>
        </div>

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-2xl bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold shadow-xl hover:shadow-2xl hover:scale-[1.02] transition duration-300">
                <span class="menu-text">Logout</span>
            </button>
        </form>
    </div>
</aside>

<script>
function toggleSidebarKaryawan() {
    const sidebar = document.getElementById('sidebarKaryawan');
    const texts = document.querySelectorAll('#sidebarKaryawan .menu-text');
    const title = document.getElementById('sidebarTitle');

    // Toggle lebar sidebar
    sidebar.classList.toggle('w-72');
    sidebar.classList.toggle('w-24');

    // Toggle semua teks
    texts.forEach(text => {
        text.classList.toggle('hidden');
    });

    // Toggle judul
    title.classList.toggle('hidden');
}
</script>