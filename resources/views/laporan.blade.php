<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan</title>
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
            <li><a href="/karyawan" class="p-2 block rounded-lg hover:bg-gray-200">Data Karyawan</a></li>
            <li><a href="/absensi" class="p-2 block rounded-lg hover:bg-gray-200">Absensi</a></li>
            <li><a href="/laporan" class="p-2 block rounded-lg bg-blue-100 text-blue-600">Laporan</a></li>
        </ul>
    </aside>

    <main class="flex-1 p-6">

        <h2 class="text-2xl font-bold mb-6">Laporan Absensi</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-gray-500">Total Hadir</h3>
                <p class="text-3xl font-bold text-green-500">120</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-gray-500">Total Izin</h3>
                <p class="text-3xl font-bold text-yellow-500">15</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-gray-500">Total Alfa</h3>
                <p class="text-3xl font-bold text-red-500">5</p>
            </div>

        </div>

    </main>
</div>

</body>
</html>