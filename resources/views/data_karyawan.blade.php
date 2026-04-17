<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Karyawan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<nav class="bg-white border-b shadow-sm px-6 py-3 flex justify-between items-center">
    <h1 class="text-xl font-bold text-gray-800">Absensi Digital</h1>
    
    <!-- Dropdown user -->
    <button id="dropdownButton" data-dropdown-toggle="dropdown" class="flex items-center gap-2 text-sm bg-gray-200 px-3 py-2 rounded-lg">
        Admin
    </button>

    <div id="dropdown" class="hidden bg-white rounded-lg shadow w-40">
        <ul class="py-2 text-sm text-gray-700">
            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a></li>
            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Logout</a></li>
        </ul>
    </div>
</nav>
<div class="flex">

    <aside class="w-64 h-screen bg-white shadow-md p-5">
        <ul class="space-y-4">
            <li><a href="/dashboard" class="p-2 block rounded-lg hover:bg-gray-200">Dashboard</a></li>
            <li><a href="/karyawan" class="p-2 block rounded-lg bg-blue-100 text-blue-600">Data Karyawan</a></li>
            <li><a href="/absensi" class="p-2 block rounded-lg hover:bg-gray-200">Absensi</a></li>
            <li><a href="/laporan" class="p-2 block rounded-lg hover:bg-gray-200">Laporan</a></li>
        </ul>
    </aside>

    <main class="flex-1 p-6">

        <h2 class="text-2xl font-bold mb-6">Data Karyawan</h2>
        
        
        <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex gap-3 mb-4">

            <button onclick="openModal()"
                class="bg-green-500 text-white px-4 py-2 rounded-lg">
                Tambah Karyawan
            </button>
    <form method="GET" action="/karyawan" class="flex gap-2">
        <input type="text" name="search" placeholder="Cari NIP..."
            class="border p-2 rounded-lg">

        <button class="bg-blue-500 text-white px-3 rounded-lg">
            Search
        </button>
    </form>

    <!-- FILTER DIVISI -->
    <form method="GET" action="/karyawan" class="flex gap-2">

        <select name="divisi" class="border p-2 rounded-lg">
            <option value="">Semua Divisi</option>
            <option value="IT">IT</option>
            <option value="HRD">HRD</option>
            <option value="Finance">Finance</option>
            <option value="Marketing">Marketing</option>
        </select>

        <button class="bg-green-500 text-white px-3 rounded-lg">
            Filter
        </button>

    </form>

</div>
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-left">
                     <tr>
            <th class="p-3">NIP</th>
            <th class="p-3">Nama</th>
            <th class="p-3">Email</th>
            <th class="p-3">Jabatan</th>
            <th class="p-3">Divisi</th>
            <th class="p-3">Aksi</th>
        </tr>
                </thead>
                <tbody>
@foreach($karyawan as $k)
<tr class="border-b">

    <td class="p-3">{{ $k->nip }}</td>
    <td class="p-3">{{ $k->nama }}</td>
    <td class="p-3">{{ $k->email }}</td>
    <td class="p-3">{{ $k->jabatan }}</td>
    <td class="p-3">{{ $k->divisi }}</td>

    <td class="p-3">
        <form action="/karyawan/{{ $k->id }}" method="POST">
            @csrf
            @method('DELETE')

            <button class="bg-red-500 text-white px-3 py-1 rounded-lg">
                Hapus
            </button>
        </form>
    </td>

</tr>
@endforeach
</tbody>
            </table>

        </div>
        <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

    <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-lg">

        <h2 class="text-xl font-bold mb-4">Tambah Karyawan</h2>

        <form action="/karyawan" method="POST" class="space-y-3">
            @csrf

            <input type="text" name="nip" placeholder="NIP"
                class="w-full p-2 border rounded-lg" required>

            <input type="text" name="nama" placeholder="Nama"
                class="w-full p-2 border rounded-lg" required>

            <input type="email" name="email" placeholder="Email"
                class="w-full p-2 border rounded-lg" required>

            <input type="text" name="jabatan" placeholder="Jabatan"
                class="w-full p-2 border rounded-lg" required>

            <input type="text" name="divisi" placeholder="Divisi"
                class="w-full p-2 border rounded-lg" required>

            <div class="flex justify-end gap-2 mt-4">

                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-300 rounded-lg">
                    Batal
                </button>

                <button class="px-4 py-2 bg-green-500 text-white rounded-lg">
                    Simpan
                </button>

            </div>

        </form>

    </div>
</div>

    </main>
</div>

</body>
<script>
function openModal() {
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>
</html>