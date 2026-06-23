<aside id="sidebar"
    class="w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white flex flex-col justify-between shadow-2xl border-r border-slate-700 transition-all duration-300 min-h-screen sticky top-0">

    {{-- HEADER --}}
    <div>
        <div class="p-5 border-b border-slate-700">
            <div class="flex items-center justify-between">
                <div id="sidebarTitle">
                    <h1 class="text-3xl font-extrabold tracking-tight mt-1">
                        CODIA-SYNC
                    </h1>
                    <p class="text-xs text-slate-400 mt-1 uppercase tracking-[0.2em] font-semibold">
                        Kepala Divisi
                    </p>
                </div>

                <button onclick="toggleSidebar()"
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
                    <a href="{{ route('divisi.dashboard') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-300
                        {{ request()->routeIs('divisi.dashboard')
                            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl font-semibold'
                            : 'text-slate-200 hover:bg-slate-700/70 hover:text-white' }}">
                        <span class="menu-text font-medium">Dashboard</span>
                    </a>
                </li>

                {{-- DATA KARYAWAN --}}
                <li>
                    <a href="{{ route('divisi.karyawan') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-300
                        {{ request()->routeIs('divisi.karyawan')
                            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl font-semibold'
                            : 'text-slate-200 hover:bg-slate-700/70 hover:text-white' }}">
                        <span class="menu-text font-medium">Data Karyawan</span>
                    </a>
                </li>

                {{-- RIWAYAT ABSENSI --}}
                <li>
                    <a href="{{ route('divisi.riwayat-absensi') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-300
                        {{ request()->routeIs('divisi.riwayat-absensi')
                            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl font-semibold'
                            : 'text-slate-200 hover:bg-slate-700/70 hover:text-white' }}">
                        <span class="menu-text font-medium">Riwayat Absensi</span>
                    </a>
                </li>

                {{-- DATA PERIZINAN --}}
                <li>
                    <a href="{{ route('divisi.data-perizinan') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-300
                        {{ request()->routeIs('divisi.data-perizinan')
                            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl font-semibold'
                            : 'text-slate-200 hover:bg-slate-700/70 hover:text-white' }}">
                        <span class="menu-text font-medium">Data Perizinan</span>
                    </a>
                </li>

                {{-- LAPORAN --}}
                <li>
                    <a href="{{ route('divisi.DivisiLaporan') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-300
                        {{ request()->routeIs('divisi.DivisiLaporan')
                            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl font-semibold'
                            : 'text-slate-200 hover:bg-slate-700/70 hover:text-white' }}">
                        <span class="menu-text font-medium">Laporan</span>
                    </a>
                </li>

                {{-- PROFIL --}}

                <li>
                    <a href="{{ route('divisi.profile') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-300
                        {{ request()->routeIs('divisi.profile')
                            ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xl font-semibold'
                            : 'text-slate-200 hover:bg-slate-700/70 hover:text-white' }}">
                        <span class="menu-text font-medium">Profil</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    {{-- FOOTER PROFILE --}}
    <div class="p-4 border-t border-slate-700 bg-slate-800/70 backdrop-blur-sm mt-auto">

        {{-- USER INFO --}}
        <div class="flex items-center gap-3 mb-4 px-2">
            <div
                class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                KD
            </div>

            <div class="menu-text">
                <p class="font-bold text-white">
                    Kepala Divisi
                </p>
                <p class="text-xs text-slate-400">
                    CODIA-SYNC System
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

    // Ubah lebar sidebar
    sidebar.classList.toggle('w-72');
    sidebar.classList.toggle('w-24');

    // Sembunyikan / tampilkan teks
    texts.forEach(text => {
        text.classList.toggle('hidden');
    });

    // Sembunyikan / tampilkan judul
    title.classList.toggle('hidden');
}
</script>