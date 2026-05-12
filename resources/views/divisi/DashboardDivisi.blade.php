<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CODIA-SYNC Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50 antialiased font-sans">

    <div class="flex">
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">
            
            <header class="bg-blue-600 p-4 flex justify-between items-center shadow-sm">
                <h1 class="text-xl font-black text-white tracking-wider">KEPALA DIVISI</h1>
                <div class="text-right">
                    <p class="text-sm font-bold text-white">Hallo, {{ $nama_user }}</p>
                </div>
            </header>

            <div class="p-6 space-y-6">
                
                <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-8 rounded-xl flex justify-between items-start shadow-lg border border-blue-400">
                    <div class="max-w-2xl">
                        <h2 class="text-4xl font-extrabold mb-4 text-white">
                            Selamat Datang di Divisi {{ $divisi }}
                        </h2>
                    </div>
                   <div class="text-right">
    <div id="clock" class="text-6xl font-mono font-black text-white">
        00 : 00 <span id="seconds" class="text-2xl align-top">00</span>
    </div>
    <p id="date" class="mt-8 text-sm font-bold text-blue-100">
        Loading...
    </p>
</div>
                </div>

                <div class="grid grid-cols-6 gap-4">
                    @php
                        $stats = [
                            ['label' => 'Total Karyawan', 'value' => $total_karyawan, 'bg' => 'bg-blue-100'],
                            ['label' => 'Hadir', 'value' => $hadir, 'bg' => 'bg-blue-100'],
                            ['label' => 'Terlambat', 'value' => $terlambat, 'bg' => 'bg-blue-100'],
                            ['label' => 'Alpha', 'value' => $alpha, 'bg' => 'bg-blue-100'],
                            ['label' => 'Izin', 'value' => $izin, 'bg' => 'bg-blue-200'],
                            ['label' => 'Sakit', 'value' => $sakit, 'bg' => 'bg-blue-200'],
                        ];
                    @endphp

                    @foreach($stats as $stat)
                        <div class="{{ $stat['bg'] }} p-5 rounded-lg shadow-sm text-center border border-blue-200">
                            <p class="text-[10px] font-black uppercase tracking-widest text-blue-700 mb-2">
                                {{ $stat['label'] }}
                            </p>
                            <p class="text-5xl font-black text-blue-900">
                                {{ $stat['value'] }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-2 bg-white p-6 rounded-xl min-h-[350px] flex flex-col justify-end shadow-sm border border-blue-200">
                        <div class="flex items-end justify-between h-48 px-10">
                            <div class="w-10 bg-blue-700 h-1/4 rounded-t"></div>
                            <div class="w-10 bg-blue-600 h-3/4 rounded-t"></div>
                            <div class="w-10 bg-blue-400 h-2/4 rounded-t"></div>
                            <div class="w-10 bg-blue-700 h-1/2 rounded-t"></div>
                            <div class="w-10 bg-blue-600 h-full rounded-t"></div>
                            <div class="w-10 bg-blue-400 h-2/3 rounded-t"></div>
                            <div class="w-10 bg-blue-700 h-3/4 rounded-t"></div>
                        </div>
                        <div class="mt-6 border-t border-blue-200 pt-3 flex justify-end gap-6 text-[9px] font-black text-blue-700">
                            <span>■ ABSENSI I</span>
                            <span>■ ABSENSI S</span>
                            <span>■ ABSENSI A</span>
                        </div>
                    </div>

                    <div class="bg-gradient-to-b from-blue-500 to-blue-600 p-6 rounded-xl shadow-lg border border-blue-400">
                        <h3 class="font-black text-sm mb-6 text-white uppercase tracking-widest">
                            Jalan Pintas:
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('divisi.riwayat-absensi') }}"
                               class="bg-white p-4 rounded-xl font-black text-[11px] h-28 flex items-center justify-center text-center text-blue-800 shadow-sm hover:scale-[1.02] transition transform">
                                RIWAYAT<br>ABSENSI
                            </a>

                            <a href="{{ route('divisi.karyawan') }}"
                               class="bg-white p-4 rounded-xl font-black text-[11px] h-28 flex items-center justify-center text-center text-blue-800 shadow-sm hover:scale-[1.02] transition transform">
                                DATA<br>KARYAWAN
                            </a>

                            <a href="{{ route('divisi.data-perizinan') }}"
                               class="col-span-2 bg-white p-4 rounded-xl font-black text-[11px] h-20 flex items-center justify-center text-blue-800 shadow-sm hover:scale-[1.01] transition transform uppercase tracking-widest">
                                Data Perizinan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function updateDateTime() {
        const now = new Date();

        // Format jam
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        // Tampilkan jam
        document.getElementById('clock').innerHTML =
            `${hours} : ${minutes} <span id="seconds" class="text-2xl align-top">${seconds}</span>`;

        // Nama hari dan bulan dalam Bahasa Indonesia
        const hari = [
            'Minggu', 'Senin', 'Selasa', 'Rabu',
            'Kamis', 'Jumat', 'Sabtu'
        ];

        const bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];

        // Format tanggal
        const tanggal = `${hari[now.getDay()]}, ${now.getDate()} ${bulan[now.getMonth()]} ${now.getFullYear()}`;

        // Tampilkan tanggal
        document.getElementById('date').textContent = tanggal;
    }

    // Jalankan pertama kali
    updateDateTime();

    // Update setiap 1 detik
    setInterval(updateDateTime, 1000);
</script>
</body>
</html>