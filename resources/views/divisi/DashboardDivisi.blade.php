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

                
                <div class="bg-white p-8 rounded-xl shadow-sm border border-blue-200">

                    <div class="flex flex-col xl:flex-row justify-between gap-8">

                        
                        <div class="flex items-center gap-6">
                            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center text-3xl font-black text-white shadow-lg">
                                {{ strtoupper(substr($nama_user, 0, 3)) }}
                            </div>

                            <div>
                                <p class="text-[10px] uppercase tracking-[0.25em] text-blue-600 font-bold mb-1">
                                    Kepala Divisi
                                </p>

                                <h3 class="text-3xl font-black text-blue-900 tracking-tight">
                                    {{ $nama_user }}
                                </h3>

                                <p class="text-lg text-blue-500 mt-1 font-semibold">
                                    Divisi {{ $divisi }}
                                </p>
                            </div>
                        </div>

                        
                        <div class="text-right">
                            <p class="text-[10px] uppercase tracking-[0.25em] text-blue-600 font-bold mb-2">
                                Status Hari Ini
                            </p>
                            @if($absensiHariIni)
                                <div class="flex items-center justify-end gap-4">
                                    <div>
                                        <p class="text-sm text-blue-700 font-semibold">Masuk: <span class="text-green-600 font-black">{{ $absensiHariIni->jam_masuk ?? '-' }}</span></p>
                                        <p class="text-sm text-blue-700 font-semibold">Pulang: <span class="text-red-500 font-black">{{ $absensiHariIni->jam_keluar ?? '-' }}</span></p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-black
                                        @if($absensiHariIni->status == 'Hadir') bg-green-100 text-green-700
                                        @elseif($absensiHariIni->status == 'Terlambat') bg-yellow-100 text-yellow-700
                                        @else bg-red-100 text-red-700
                                        @endif">
                                        {{ $absensiHariIni->status }}
                                    </span>
                                </div>
                            @else
                                <p class="text-sm text-blue-400 italic">Belum absen hari ini</p>
                            @endif
                        </div>
                    </div>

                    
                    @if(session('success'))
                        <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm font-semibold">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm font-semibold">
                            {{ session('error') }}
                        </div>
                    @endif

                    
                    <div class="flex justify-end gap-4 mt-6">

                        
                        @if(!$absensiHariIni)
                            <form action="{{ route('divisi.absensi.masuk') }}" method="POST" class="absensi-form">
                                @csrf
                                <button type="submit"
                                    class="w-44 bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-xl font-black text-lg shadow-lg hover:shadow-xl hover:scale-105 transition duration-300">
                                    Masuk
                                </button>
                            </form>
                        @else
                            <button disabled
                                class="w-44 bg-blue-200 text-blue-400 py-3 rounded-xl font-black text-lg cursor-not-allowed">
                                ✓ Sudah Masuk
                            </button>
                        @endif

                        
                        @if($absensiHariIni && !$absensiHariIni->jam_keluar)
                            <form action="{{ route('divisi.absensi.keluar') }}" method="POST" class="absensi-form">
                                @csrf
                                <button type="submit"
                                    class="w-44 bg-white border-2 border-blue-300 text-blue-700 py-3 rounded-xl font-black text-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition duration-300">
                                    Pulang
                                </button>
                            </form>
                        @elseif($absensiHariIni && $absensiHariIni->jam_keluar)
                            <button disabled
                                class="w-44 bg-blue-200 text-blue-400 py-3 rounded-xl font-black text-lg cursor-not-allowed">
                                ✓ Sudah Pulang
                            </button>
                        @else
                            <button disabled
                                class="w-44 bg-gray-100 text-gray-300 py-3 rounded-xl font-black text-lg cursor-not-allowed">
                                Pulang
                            </button>
                        @endif

                    </div>
                </div>

                
                <div class="bg-white rounded-xl shadow-sm border border-blue-200 overflow-hidden">
                    <div class="p-6 border-b border-blue-100">
                        <h3 class="text-sm font-black uppercase tracking-widest text-blue-700">
                            Riwayat Absensi Pribadi
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-blue-600 text-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-wider">Jam Masuk</th>
                                    <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-wider">Jam Pulang</th>
                                    <th class="px-6 py-3 text-left text-xs font-black uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($aktivitas as $item)
                                    <tr class="border-b border-blue-50 hover:bg-blue-50 transition duration-200">
                                        <td class="px-6 py-3 text-sm font-semibold text-blue-800">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-3 text-sm text-blue-700">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                        <td class="px-6 py-3 text-sm font-semibold text-green-600">{{ $item->jam_masuk ?? '-' }}</td>
                                        <td class="px-6 py-3 text-sm font-semibold text-red-500">{{ $item->jam_keluar ?? '-' }}</td>
                                        <td class="px-6 py-3">
                                            <span class="px-3 py-1 rounded-full text-xs font-black
                                                @if($item->status == 'Hadir') bg-green-100 text-green-700
                                                @elseif($item->status == 'Terlambat') bg-yellow-100 text-yellow-700
                                                @elseif($item->status == 'Izin') bg-blue-100 text-blue-700
                                                @else bg-red-100 text-red-700
                                                @endif">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-10 text-center text-blue-300 italic text-sm">
                                            Belum ada riwayat absensi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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

        
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        
        document.getElementById('clock').innerHTML =
            `${hours} : ${minutes} <span id="seconds" class="text-2xl align-top">${seconds}</span>`;

        
        const hari = [
            'Minggu', 'Senin', 'Selasa', 'Rabu',
            'Kamis', 'Jumat', 'Sabtu'
        ];

        const bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];

        
        const tanggal = `${hari[now.getDay()]}, ${now.getDate()} ${bulan[now.getMonth()]} ${now.getFullYear()}`;

        
        document.getElementById('date').textContent = tanggal;
    }

    
    updateDateTime();

    
    setInterval(updateDateTime, 1000);
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.absensi-form');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const button = form.querySelector('button[type="submit"]');
                const originalText = button.innerHTML;
                button.disabled = true;
                button.innerHTML = '<span class="inline-block animate-spin mr-2">⏳</span>Mendapatkan GPS...';

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;

                            
                            let latInput = form.querySelector('input[name="latitude"]');
                            if (!latInput) {
                                latInput = document.createElement('input');
                                latInput.type = 'hidden';
                                latInput.name = 'latitude';
                                form.appendChild(latInput);
                            }
                            latInput.value = lat;

                            let lngInput = form.querySelector('input[name="longitude"]');
                            if (!lngInput) {
                                lngInput = document.createElement('input');
                                lngInput.type = 'hidden';
                                lngInput.name = 'longitude';
                                form.appendChild(lngInput);
                            }
                            lngInput.value = lng;

                            
                            form.submit();
                        },
                        function(error) {
                            button.disabled = false;
                            button.innerHTML = originalText;
                            
                            let errorMessage = 'Gagal memverifikasi lokasi GPS. ';
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessage += 'Mohon izinkan akses lokasi (GPS) pada browser Anda.';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessage += 'Informasi lokasi tidak tersedia.';
                                    break;
                                case error.TIMEOUT:
                                    errorMessage += 'Waktu permintaan lokasi habis.';
                                    break;
                                default:
                                    errorMessage += 'Terjadi kesalahan tidak dikenal.';
                            }
                            alert(errorMessage);
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                } else {
                    button.disabled = false;
                    button.innerHTML = originalText;
                    alert('Browser Anda tidak mendukung deteksi lokasi GPS.');
                }
            });
        });
    });
</script>
</body>
</html>
