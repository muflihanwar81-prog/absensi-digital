<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CODIA-SYNC Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-200 antialiased font-sans">

    <div class="flex">
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">
            
            <header class="bg-blue-500 p-4 flex justify-between items-center shadow-sm">
                <h1 class="text-xl font-black text-gray-800 tracking-wider">KEPALA DIVISI</h1>
                <div class="text-right">
                    <p class="text-sm font-bold">Hallo, {{ $nama_user }}</p>
                </div>
            </header>

            <div class="p-6 space-y-6">
                
                <div class="bg-gray-300 p-8 rounded-xl flex justify-between items-start shadow-sm border border-gray-400/20">
                    <div class="max-w-2xl">
                        <h2 class="text-4xl font-extrabold mb-4 text-gray-800">Selamat Datang di Divisi {{ $divisi }}</h2>
                    </div>
                    <div class="text-right">
                        <div class="text-6xl font-mono font-black text-gray-800">08 : 57 <span class="text-2xl align-top">25</span></div>
                        <p class="mt-8 text-sm font-bold text-gray-500">Tanggal 2 Nov 2026</p>
                    </div>
                </div>

                <div class="grid grid-cols-6 gap-4">
                    @php
                        $stats = [
                            ['label' => 'Total Karyawan', 'value' => $total_karyawan, 'bg' => 'bg-gray-300'],
                            ['label' => 'Hadir', 'value' => $hadir, 'bg' => 'bg-gray-300'],
                            ['label' => 'Terlambat', 'value' => $terlambat, 'bg' => 'bg-gray-300'],
                            ['label' => 'Alpha', 'value' => $alpha, 'bg' => 'bg-gray-300'],
                            ['label' => 'Izin', 'value' => $izin, 'bg' => 'bg-gray-400'],
                            ['label' => 'Sakit', 'value' => $sakit, 'bg' => 'bg-gray-400'],
                        ];
                    @endphp

                    @foreach($stats as $stat)
                        <div class="{{ $stat['bg'] }} p-5 rounded-lg shadow-sm text-center border border-gray-400/10">
                            <p class="text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">{{ $stat['label'] }}</p>
                            <p class="text-5xl font-black text-gray-800">{{ $stat['value'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-2 bg-gray-300 p-6 rounded-xl min-h-[350px] flex flex-col justify-end border border-gray-400/20">
                        <div class="flex items-end justify-between h-48 px-10">
                            <div class="w-10 bg-gray-600 h-1/4 rounded-t"></div>
                            <div class="w-10 bg-gray-500 h-3/4 rounded-t"></div>
                            <div class="w-10 bg-gray-400 h-2/4 rounded-t"></div>
                            <div class="w-10 bg-gray-600 h-1/2 rounded-t"></div>
                            <div class="w-10 bg-gray-500 h-full rounded-t"></div>
                            <div class="w-10 bg-gray-400 h-2/3 rounded-t"></div>
                            <div class="w-10 bg-gray-600 h-3/4 rounded-t"></div>
                        </div>
                        <div class="mt-6 border-t border-gray-400 pt-3 flex justify-end gap-6 text-[9px] font-black text-gray-600">
                            <span>■ ABSENSI I</span>
                            <span>■ ABSENSI S</span>
                            <span>■ ABSENSI A</span>
                        </div>
                    </div>

                    <div class="bg-gray-400 p-6 rounded-xl border border-gray-500/20">
                        <h3 class="font-black text-sm mb-6 text-gray-800 uppercase tracking-widest">Jalan Pintas:</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('divisi.riwayat-absensi') }}" class="bg-white p-4 rounded-xl font-black text-[11px] h-28 flex items-center justify-center text-center shadow-sm hover:scale-[1.02] transition transform">
                                RIWAYAT<br>ABSENSI
                            </a>
                            <a href="{{ route('divisi.karyawan') }}" class="bg-white p-4 rounded-xl font-black text-[11px] h-28 flex items-center justify-center text-center shadow-sm hover:scale-[1.02] transition transform">
                                DATA<br>KARYAWAN
                            </a>
                            <a href="{{ route('divisi.data-perizinan') }}" class="col-span-2 bg-white p-4 rounded-xl font-black text-[11px] h-20 flex items-center justify-center shadow-sm hover:scale-[1.01] transition transform uppercase tracking-widest">
                                Data Perizinan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>