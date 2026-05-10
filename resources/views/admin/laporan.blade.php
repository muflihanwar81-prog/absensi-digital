<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-200">

<div class="flex">

    @include('layouts.sidebar')

    <main class="flex-1 p-6">

        <div class="bg-white shadow rounded-lg overflow-hidden">

            <div class="bg-gray-300 p-5">
                <h1 class="text-3xl font-bold">
                    Laporan
                </h1>
            </div>

            <div class="p-5 flex flex-wrap gap-3 items-center">

                <input type="text"
                    placeholder="Pencarian.."
                    class="border px-4 py-2 rounded-lg">

                <input type="date"
                    class="border px-4 py-2 rounded-lg">

                <span>S/D</span>

                <input type="date"
                    class="border px-4 py-2 rounded-lg">

                <button
                    class="bg-gray-300 px-5 py-2 rounded-lg hover:bg-gray-400">

                    Filter
                </button>

                <div class="ml-auto flex gap-3">

                    <button
                        class="bg-gray-300 px-5 py-2 rounded-lg hover:bg-gray-400">

                        Excel
                    </button>

                    <button
                        class="bg-gray-300 px-5 py-2 rounded-lg hover:bg-gray-400">

                        PDF
                    </button>

                </div>

            </div>

            {{-- TABLE --}}
            <div class="p-5">

                <div class="overflow-x-auto border rounded-lg">

                    <table class="w-full border-collapse">

                        <thead class="bg-gray-200">

                            <tr>

                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">NIP</th>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Divisi</th>
                                <th class="border px-4 py-2">Jabatan</th>
                                <th class="border px-4 py-2">Jam Masuk</th>
                                <th class="border px-4 py-2">Jam Keluar</th>
                                <th class="border px-4 py-2">Tanggal</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($data as $item)

                            <tr>

                                <td class="border px-4 py-2">
                                    {{ $loop->iteration }}
                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="8"
                                    class="border px-4 py-10 text-center text-gray-500">

                                    Data kosong

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

</body>
</html>