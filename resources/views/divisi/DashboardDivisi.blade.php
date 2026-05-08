<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan - CODIA-SYNC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex font-sans h-screen overflow-hidden">

    @include('layouts.partials.sidebar-divisi')

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white p-4 px-8 border-b border-gray-200 flex justify-between items-center shadow-sm">
            <h2 class="font-bold text-xl tracking-wider text-gray-800">CODIA-SYNC</h2>
            <div class="flex items-center gap-3">
                <p class="text-sm font-medium text-gray-600">Hallo, <span class="font-bold text-gray-900">Dio Kurniawan</span></p>
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                    DK
                </div>
            </div>
        </header>

        <div class="p-8 space-y-6">
            
            <div class="bg-gray-200 rounded-2xl p-10 flex justify-between items-center shadow-sm border border-gray-300">
                <div class="space-y-8">
                    <h1 class="text-4xl font-black text-gray-800 tracking-tight">Selamat Datang Karyawan</h1>
                    <div class="flex gap-6">
                        <button class="bg-white px-16 py-4 rounded-xl font-bold text-lg shadow-sm hover:bg-gray-50 active:scale-95 transition-all">
                            Masuk
                        </button>
                        <button class="bg-white px-16 py-4 rounded-xl font-bold text-lg shadow-sm hover:bg-gray-50 active:scale-95 transition-all">
                            Pulang
                        </button>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-8xl font-black tracking-tighter text-gray-900 flex items-start justify-end">
                        <span>08 : 57</span>
                        <span class="text-4xl ml-2 mt-2">25</span>
                    </div>
                    <p class="text-gray-600 mt-4 text-xl font-semibold">Tanggal 2 Nov 2026</p>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-6">
                @php
                    $stats = [
                        ['label' => 'Hadir', 'value' => 20],
                        ['label' => 'Terlambat', 'value' => 5],
                        ['label' => 'Alpha', 'value' => 2],
                        ['label' => 'Izin', 'value' => 0],
                    ];
                @endphp
                @foreach($stats as $s)
                <div class="bg-gray-200 p-8 rounded-2xl border border-gray-300 text-center shadow-sm">
                    <p class="text-xl font-bold mb-3 text-gray-800">{{ $s['label'] }}</p>
                    <h3 class="text-7xl font-black text-gray-900">{{ $s['value'] }}</h3>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-3 gap-8">
                <div class="col-span-2 bg-white p-8 rounded-2xl border border-gray-200 shadow-sm min-h-[400px] flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-full h-64 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200 flex items-center justify-center">
                            <p class="text-gray-400 font-medium">[ Grafik Kehadiran Mingguan ]</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-200 p-8 rounded-2xl border border-gray-300 shadow-sm flex flex-col">
                    <h4 class="font-bold text-xl mb-8 text-gray-800">Short Cut Menu</h4>
                    <div class="space-y-6 flex-1 flex flex-col justify-center">
                        <a href="#" class="block bg-white p-8 rounded-2xl text-center text-xl font-bold shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-gray-100">
                            Data Kehadiran
                        </a>
                        <a href="#" class="block bg-white p-8 rounded-2xl text-center text-xl font-bold shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-gray-100">
                            Pengajuan Izin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>