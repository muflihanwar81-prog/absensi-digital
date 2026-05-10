{{-- resources/views/karyawan/dashboard.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-200 font-sans">

    <div class="flex min-h-screen">

        @include('layouts.sidebar_karyawan')

        <main class="flex-1">

            <div class="bg-[#efefef] border-b border-gray-400 px-6 py-3 flex justify-between items-center">
                <h1 class="text-3xl font-bold">Presensia</h1>
                <p class="text-sm font-semibold">
                    Hallo, {{ session('karyawan_nama', 'Karyawan') }}
                </p>
            </div>

            <div class="p-6">

                <div class="bg-gray-300 rounded-lg p-6 mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-4xl font-bold mb-2">Selamat Datang Karyawan</h2>
                    </div>
                    <div class="text-xl font-semibold text-gray-700">
                        {{ session('karyawan_divisi', 'Divisi') }}
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-4 mb-6">

                    <div class="bg-gray-300 rounded-lg p-4">
                        <p class="font-semibold mb-2">Hadir</p>
                        <p class="text-5xl font-bold text-center">{{ $hadir ?? 0 }}</p>
                    </div>

                    <div class="bg-gray-300 rounded-lg p-4">
                        <p class="font-semibold mb-2">Terlambat</p>
                        <p class="text-5xl font-bold text-center">{{ $terlambat ?? 0 }}</p>
                    </div>

                    <div class="bg-gray-300 rounded-lg p-4">
                        <p class="font-semibold mb-2">Tidak Hadir</p>
                        <p class="text-5xl font-bold text-center">{{ $tidakHadir ?? 0 }}</p>
                    </div>

                    <div class="bg-gray-300 rounded-lg p-4">
                        <p class="font-semibold mb-2">Izin</p>
                        <p class="text-5xl font-bold text-center">{{ $izin ?? 0 }}</p>
                    </div>

                </div>

                <div class="bg-gray-300 rounded-lg p-6 mb-6">

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-6">
                            <div
                                class="w-28 h-28 rounded-full bg-gray-400 flex items-center justify-center text-5xl font-bold text-black">
                                {{ strtoupper(substr(session('karyawan_nama', 'Karyawan'), 0, 3)) }}
                            </div>

                            <div>
                                <h3 class="text-4xl font-bold">
                                    {{ session('karyawan_nama', 'Karyawan') }}
                                </h3>
                                <p class="text-2xl text-gray-700">
                                    {{ session('karyawan_jabatan', 'Karyawan') }}
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <div id="clock" class="text-6xl font-bold leading-none">
                                08 : 57
                            </div>
                            <div id="date" class="text-lg text-gray-700 mt-2">
                                Kamis, 2 Nov 2026
                            </div>
                        </div>

                    </div>

                    <div class="flex justify-end gap-4 mt-6">
                        <button
                            class="w-48 bg-gray-400 hover:bg-gray-500 py-3 rounded font-bold text-xl shadow">
                            Masuk
                        </button>

                        <button
                            class="w-48 bg-white hover:bg-gray-100 py-3 rounded font-bold text-xl shadow border border-gray-300">
                            Pulang
                        </button>
                    </div>

                </div>

                <div>
                    <h3 class="text-2xl font-bold mb-3">Aktivitas Hari Ini :</h3>

                    <div class="bg-white border border-black overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th class="border border-black px-4 py-2 text-left">No</th>
                                    <th class="border border-black px-4 py-2 text-left">Nama Karyawan</th>
                                    <th class="border border-black px-4 py-2 text-left">Tanggal</th>
                                    <th class="border border-black px-4 py-2 text-left">Waktu</th>
                                    <th class="border border-black px-4 py-2 text-left">Keterangan</th>
                                </tr>
                            </thead>

                            <tbody>
    @php
        $aktivitas = $aktivitas ?? collect();
    @endphp

    @forelse($aktivitas as $item)
        <tr>
            <td class="border border-black px-4 py-2">
                {{ $loop->iteration }}
            </td>

            <td class="border border-black px-4 py-2">
                {{ data_get($item, 'nama', session('karyawan_nama')) }}
            </td>

            <td class="border border-black px-4 py-2">
                {{ data_get($item, 'tanggal', '-') }}
            </td>

            <td class="border border-black px-4 py-2">
                {{ data_get($item, 'jam_masuk', data_get($item, 'waktu', '-')) }}
            </td>

            <td class="border border-black px-4 py-2">
                {{ data_get($item, 'status', '-') }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5"
                class="border border-black py-10 text-center text-gray-500">
                Belum ada aktivitas hari ini.
            </td>
        </tr>
    @endforelse
</tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>

    </div>

    <script>
        function updateClock() {
            const now = new Date();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            document.getElementById('clock').textContent = `${hours} : ${minutes}`;

            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };

            document.getElementById('date').textContent =
                now.toLocaleDateString('id-ID', options);
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>

</body>

</html>