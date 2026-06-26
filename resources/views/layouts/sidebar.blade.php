<aside id="sidebar"
    class="w-72 bg-slate-900 text-white flex flex-col justify-between shadow-xl border-r border-slate-800 transition-all duration-300 h-screen sticky top-0 z-50">

    {{-- HEADER --}}
    <div>
        <div class="p-6 border-b border-slate-800">
            <div class="flex items-center justify-between">
                <div id="sidebarTitle" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center font-bold text-white shadow-lg shadow-blue-500/30">
                        C
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-white">
                        CODIA<span class="text-blue-500">.</span>
                    </h1>
                </div>

                <button onclick="toggleSidebar()"
                    class="bg-slate-800 hover:bg-slate-700 text-slate-300 p-2 rounded-lg transition duration-200 shadow-sm border border-slate-700/50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
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
            <ul class="space-y-1.5">

                {{-- DASHBOARD --}}
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->is('dashboard') 
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold' 
                            : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                        <i class="fa-solid fa-chart-line text-lg w-5 text-center"></i>
                        <span class="menu-text font-medium text-sm">Dashboard</span>
                    </a>
                </li>

                {{-- KELOLA DIVISI --}}
                <li>
                    <a href="{{ route('admin.keloladivisi') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->is('keloladivisi*') 
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold' 
                            : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                        <i class="fa-solid fa-building text-lg w-5 text-center"></i>
                        <span class="menu-text font-medium text-sm">Kelola Divisi</span>
                    </a>
                </li>

                {{-- DATA KARYAWAN --}}
                <li>
                    <a href="{{ route('admin.karyawan') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->is('karyawan*') 
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold' 
                            : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                        <i class="fa-solid fa-users text-lg w-5 text-center"></i>
                        <span class="menu-text font-medium text-sm">Data Karyawan</span>
                    </a>
                </li>

                {{-- DATA KEHADIRAN --}}
                <li>
                    <a href="{{ route('admin.absensi.index') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->is('absensi*') 
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold' 
                            : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                        <i class="fa-solid fa-calendar-check text-lg w-5 text-center"></i>
                        <span class="menu-text font-medium text-sm">Data Kehadiran</span>
                    </a>
                </li>

                {{-- DATA PERIZINAN --}}
                <li>
                    <a href="{{ route('admin.perizinan.index') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->is('perizinan*') 
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold' 
                            : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                        <i class="fa-solid fa-file-signature text-lg w-5 text-center"></i>
                        <span class="menu-text font-medium text-sm">Data Perizinan</span>
                    </a>
                </li>

                {{-- LAPORAN --}}
                <li>
                    <a href="{{ route('admin.laporan') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->is('laporan') 
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold' 
                            : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                        <i class="fa-solid fa-file-invoice-dollar text-lg w-5 text-center"></i>
                        <span class="menu-text font-medium text-sm">Laporan</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    {{-- FOOTER PROFILE --}}
    <div class="p-4 border-t border-slate-800 bg-slate-900/60 backdrop-blur-sm">

        {{-- USER INFO --}}
        <div class="flex items-center gap-3 mb-4 px-2">
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-white/10">
                DK
            </div>

            <div class="menu-text min-w-0">
                <p class="font-bold text-slate-100 text-sm truncate">
                    Dio Kurniawan
                </p>
                <p class="text-xs text-slate-400 truncate">
                    Administrator
                </p>
            </div>
        </div>

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white font-semibold border border-rose-500/20 hover:border-transparent transition duration-200 text-sm">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="menu-text">Logout</span>
            </button>
        </form>
    </div>
</aside>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const texts = document.querySelectorAll('.menu-text');
    const title = document.getElementById('sidebarTitle');

    sidebar.classList.toggle('w-72');
    sidebar.classList.toggle('w-20');

    texts.forEach(text => {
        text.classList.toggle('hidden');
    });

    title.classList.toggle('hidden');
}
</script>