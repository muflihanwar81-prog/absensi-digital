<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Karyawan - CODIA-SYNC</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-header { background-color: #6a96e6; }
        .bg-sidebar { background-color: #72a1ed; }
        
        /* Card Gradients sesuai foto */
        .card-hadir { background: linear-gradient(180deg, #4caf50 45%, #2e7d32 45%); }
        .card-terlambat { background: linear-gradient(180deg, #ffb74d 45%, #f57c00 45%); }
        .card-izin { background: linear-gradient(180deg, #64b5f6 45%, #1976d2 45%); }
        .card-tanpa { background: linear-gradient(180deg, #ef5350 45%, #d32f2f 45%); }

        /* Tombol Absensi 3D Style */
        .btn-masuk { background-color: #8ce65a; border-bottom: 5px solid #6db345; transition: 0.1s; }
        .btn-masuk:active { border-bottom: 0; transform: translateY(5px); }
        .btn-pulang { background-color: #f26b6b; border-bottom: 5px solid #c95555; transition: 0.1s; }
        .btn-pulang:active { border-bottom: 0; transform: translateY(5px); }
    </style>
</head>
<body class="bg-white">

    <header class="fixed top-0 z-50 w-full bg-header text-white px-6 py-3 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-[10px] text-gray-600 font-bold uppercase">Logo</div>
            <h1 class="text-xl font-bold tracking-wider italic">CODIA-SYNC</h1>
        </div>
        <div class="text-sm font-medium">Hallo, {{ Auth::user()->name ?? 'Karyawan' }}</div>
    </header>

    <div class="flex pt-16">
        <aside class="fixed left-0 z-40 w-64 h-screen bg-sidebar shadow-inner">
            <div class="h-full flex flex-col justify-between overflow-y-auto">
                <ul class="space-y-0 font-medium">
                    <li>
                        <a href="#" class="block p-4 text-gray-900 bg-white font-bold border-b border-blue-200">
                            Dashboard Kehadiran
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-4 text-white hover:bg-blue-400 border-b border-blue-400 transition">
                            Data Kehadiran
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-4 text-white hover:bg-blue-400 border-b border-blue-400 transition">
                            Pengajuan Izin
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-4 text-white hover:bg-blue-400 border-b border-blue-400 transition">
                            Pengajuan Lembur
                        </a>
                    </li>
                </ul>
                
                <div class="p-4 bg-slate-700 flex items-center gap-3 text-white">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-800">
                        {{ substr(Auth::user()->name ?? 'DK', 0, 2) }}
                    </div>
                    <div class="text-xs">
                        <p class="font-bold">{{ Auth::user()->name ?? 'Dio Kurniawan' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 ml-64 p-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-1">Selamat Datang Karyawan.</h2>
            <p class="text-gray-400 mb-8 text-lg">Tanggal {{ date('d M Y') }}</p>

            <div class="grid grid-cols-4 gap-4 mb-10">
                <div class="card-hadir p-4 rounded-2xl text-white shadow-md">
                    <p class="text-xs font-bold uppercase italic mb-3">Hadir</p>
                    <p class="text-5xl font-bold">1</p>
                </div>
                <div class="card-terlambat p-4 rounded-2xl text-white shadow-md">
                    <p class="text-xs font-bold uppercase italic mb-3">Terlambat</p>
                    <p class="text-5xl font-bold">0</p>
                </div>
                <div class="card-izin p-4 rounded-2xl text-white shadow-md">
                    <p class="text-xs font-bold uppercase italic mb-3">Izin</p>
                    <p class="text-5xl font-bold">3</p>
                </div>
                <div class="card-tanpa p-4 rounded-2xl text-white shadow-md">
                    <p class="text-[10px] font-bold uppercase italic mb-3 leading-tight">Tanpa Keterangan</p>
                    <p class="text-5xl font-bold">0</p>
                </div>
            </div>

            <hr class="border-gray-300 mb-10">

            <div class="mb-12">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Kehadiran</h3>
                <div class="grid grid-cols-2 gap-10">
                    <form action="/absen-masuk" method="POST">
                        @csrf
                        <button type="submit" class="btn-masuk w-full py-6 rounded-2xl text-4xl font-black text-gray-800 uppercase tracking-widest">
                            Masuk
                        </button>
                    </form>
                    <form action="/absen-pulang" method="POST">
                        @csrf
                        <button type="submit" class="btn-pulang w-full py-6 rounded-2xl text-4xl font-black text-gray-800 uppercase tracking-widest">
                            Pulang
                        </button>
                    </form>
                </div>
            </div>

            <hr class="border-gray-300 mb-10">

            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-6">Riwayat Kehadiran Hari ini</h3>
                <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-12 flex justify-center items-center">
                    <div class="bg-gray-50 border-2 border-gray-200 rounded-2xl p-6">
    @if($absensiHariIni)
        <div class="flex justify-around text-center">
            <div>
                <p class="text-gray-500">Jam Masuk</p>
                <p class="text-2xl font-bold text-green-600">{{ $absensiHariIni->jam_masuk }}</p>
            </div>
            <div>
                <p class="text-gray-500">Jam Pulang</p>
                <p class="text-2xl font-bold text-red-600">{{ $absensiHariIni->jam_pulang ?? '--:--' }}</p>
            </div>
        </div>
    @else
        <p class="text-center text-gray-400 italic">Belum ada aktivitas absensi hari ini.</p>
    @endif
</div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>