<aside id="sidebarKaryawan"
    class="w-72 bg-slate-900 text-white flex flex-col justify-between shadow-xl border-r border-slate-800 transition-all duration-300 h-screen">

    
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

                <button onclick="toggleSidebarKaryawan()"
                    class="bg-slate-800 hover:bg-slate-700 text-slate-300 p-2 rounded-lg transition duration-200 shadow-sm border border-slate-700/50">
                    <svg xmlns="http:
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

        
        <nav class="px-4 py-6">
            <ul class="space-y-1.5">

                
                <li>
                    <a href="{{ url('/dashboard_karyawan') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->is('dashboard_karyawan')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold'
                            : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                        <i class="fa-solid fa-chart-line text-lg w-5 text-center"></i>
                        <span class="menu-text font-medium text-sm">Dashboard</span>
                    </a>
                </li>

                
                <li>
                    <a href="{{ url('/karyawan_absen') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->is('karyawan_absen')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold'
                            : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                        <i class="fa-solid fa-calendar-check text-lg w-5 text-center"></i>
                        <span class="menu-text font-medium text-sm">Data Kehadiran</span>
                    </a>
                </li>

                
                <li>
                    <a href="{{ url('/izin') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->is('izin')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold'
                            : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                        <i class="fa-solid fa-file-signature text-lg w-5 text-center"></i>
                        <span class="menu-text font-medium text-sm">Pengajuan Izin</span>
                    </a>
                </li>

                
                <li>
                    <a href="{{ url('/profile') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->is('profile')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold'
                            : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                        <i class="fa-solid fa-user text-lg w-5 text-center"></i>
                        <span class="menu-text font-medium text-sm">Profil</span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

    
    <div class="p-4 border-t border-slate-800 bg-slate-900/60 backdrop-blur-sm">

        
        <a href="{{ url('/profile') }}" class="flex items-center gap-3 mb-4 px-2 hover:bg-slate-800/50 py-2 rounded-xl transition duration-200 group">
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-white/10 group-hover:scale-105 transition-transform duration-200 shrink-0">
                {{ strtoupper(substr(session('karyawan_nama', 'Karyawan'), 0, 2)) }}
            </div>

            <div class="menu-text min-w-0">
                <p class="font-bold text-slate-100 text-sm truncate group-hover:text-blue-400 transition-colors">
                    {{ session('karyawan_nama', 'Karyawan') }}
                </p>
                <p class="text-xs text-slate-450 truncate">
                    Karyawan Aktif
                </p>
            </div>
        </a>

        
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
function toggleSidebarKaryawan() {
    const sidebar = document.getElementById('sidebarKaryawan');
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
