<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Absensi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    
    <nav class="bg-white border-b shadow-sm px-6 py-3 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Absensi Digital</h1>

        <div class="relative">
            <button onclick="toggleDropdown()" class="flex items-center gap-2 text-sm bg-gray-200 px-3 py-2 rounded-lg">
                {{ auth()->user()->name }}
            </button>

            <div id="dropdown" class="hidden absolute right-0 mt-2 bg-white rounded-lg shadow w-40">
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <a href="
                    </li>
                    <li>
                        <form method="POST" action="{{ url('/logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="flex">

        
        <aside class="w-64 h-screen bg-white shadow-md p-5">
            <ul class="space-y-4">
                <li>
                    <a href="/dashboard"
                        class="p-2 block rounded-lg {{ request()->is('dashboard') ? 'bg-blue-100 text-blue-600' : 'hover:bg-gray-200' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/karyawan"
                        class="p-2 block rounded-lg {{ request()->is('karyawan*') ? 'bg-blue-100 text-blue-600' : 'hover:bg-gray-200' }}">
                        Data Karyawan
                    </a>
                </li>
                <li>
                    <a href="/absensi"
                        class="p-2 block rounded-lg {{ request()->is('absensi') ? 'bg-blue-100 text-blue-600' : 'hover:bg-gray-200' }}">
                        Absensi
                    </a>
                </li>
                <li>
                    <a href="/laporan"
                        class="p-2 block rounded-lg {{ request()->is('laporan') ? 'bg-blue-100 text-blue-600' : 'hover:bg-gray-200' }}">
                        Laporan
                    </a>
                </li>
            </ul>
        </aside>

        
        <main class="flex-1 p-6">

            <h2 class="text-2xl font-bold mb-6">Absensi</h2>

            <div class="bg-white p-6 rounded-2xl shadow">

                
                <form method="GET" action="{{ url('/absensi') }}" class="mb-4 flex gap-2">
                    <input type="date" name="dari" value="{{ request('dari') }}" class="border p-2 rounded">
                    <input type="date" name="sampai" value="{{ request('sampai') }}" class="border p-2 rounded">
                    <button type="submit" class="bg-blue-500 text-white px-4 rounded">
                        Filter
                    </button>
                </form>

                
                <table class="w-full text-sm border">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="p-3">NIP</th>
                            <th class="p-3">Nama</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Divisi</th>
                            <th class="p-3">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $a)
                        <tr class="border-b">
                            <td class="p-3">{{ optional($a->karyawan)->nip }}</td>
                            <td class="p-3">{{ optional($a->karyawan)->nama }}</td>
                            <td class="p-3">
                                {{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}
                            </td>
                            <td class="p-3 
                                @if($a->status == 'hadir') text-green-500
                                @elseif($a->status == 'izin') text-yellow-500
                                @elseif($a->status == 'sakit') text-blue-500
                                @else text-red-500
                                @endif">
                                {{ ucfirst($a->status) }}
                            </td>
                            <td class="p-3">{{ optional($a->karyawan)->divisi }}</td>
                            <td class="p-3">{{ optional($a->karyawan)->jabatan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center p-4 text-gray-500">
                                Tidak ada data
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </main>
    </div>

    
    <script>
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('hidden');
        }
    </script>

</body>

</html>
