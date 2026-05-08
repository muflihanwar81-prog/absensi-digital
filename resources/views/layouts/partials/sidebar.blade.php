<aside id="sidebar"
class="w-64 bg-[#efefef] flex flex-col justify-between border-r transition-all duration-300 h-screen">

    <div>

        <div class="p-5 flex items-center justify-between">

            <h1 id="sidebarTitle" class="text-2xl font-bold text-gray-700">
                CODIA
            </h1>

            <button onclick="toggleSidebar()"
                class="bg-gray-300 p-2 rounded-lg hover:bg-gray-400">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"/>
                </svg>

            </button>

        </div>

        <ul class="space-y-2 px-4">

            <li>
                <a <a href="/dashboard"
    class="flex items-center gap-3 px-4 py-3 rounded-lg
    {{ request()->is('dashboard') ? 'bg-gray-300 font-semibold' : 'hover:bg-gray-300' }}">
                    <span>🏠</span>
                    <span class="menu-text">Dashboard</span>

                </a>
            </li>

            <li>
                <a href="/admindatakaryawan"
    class="flex items-center gap-3 px-4 py-3 rounded-lg
    {{ request()->is('admindatakaryawan') ? 'bg-gray-300 font-semibold' : 'hover:bg-gray-300' }}">

                    <span>👨‍💼</span>
                    <span class="menu-text">Data Karyawan</span>

                </a>
            </li>

            <li>
                <a href="#"
                    class="flex items-center gap-3 hover:bg-gray-300 px-4 py-3 rounded-lg">

                    <span>🏢</span>
                    <span class="menu-text">Kelola Divisi</span>

                </a>
            </li>

            <li>
                <a href="/admindataabsensi"
    class="flex items-center gap-3 px-4 py-3 rounded-lg
    {{ request()->is('admindatabsensi') ? 'bg-gray-300 font-semibold' : 'hover:bg-gray-300' }}">
                    <span>📅</span>
                    <span class="menu-text">Data Kehadiran</span>

                </a>
            </li>

            <li>
                <a href="/admindataperizinan"
    class="flex items-center gap-3 px-4 py-3 rounded-lg
    {{ request()->is('admindataperizinan') ? 'bg-gray-300 font-semibold' : 'hover:bg-gray-300' }}">

                    <span>📄</span>
                    <span class="menu-text">Data Perizinan</span>

                </a>
            </li>

            <li>
                <a href="/laporan"
                    class="flex items-center gap-3 hover:bg-gray-300 px-4 py-3 rounded-lg">

                    <span>📊</span>
                    <span class="menu-text">Laporan</span>

                </a>
            </li>

        </ul>

    </div>

    <div class="p-4 bg-gray-300 text-xl font-bold flex items-center gap-3">
        <span>👤</span>
        <span class="menu-text">DK</span>
    </div>

</aside>

<script>
function toggleSidebar() {

    const sidebar = document.getElementById('sidebar');
    const texts = document.querySelectorAll('.menu-text');
    const title = document.getElementById('sidebarTitle');

    sidebar.classList.toggle('w-64');
    sidebar.classList.toggle('w-24');

    texts.forEach(text => {
        text.classList.toggle('hidden');
    });

    title.classList.toggle('hidden');
}
</script>