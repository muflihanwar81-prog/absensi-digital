<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Divisi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-200">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('layouts.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1">

        {{-- HEADER --}}
        <div class="bg-[#efefef] border-b">

            <div class="flex items-center gap-5 px-6 py-4">

                <div class="w-12 h-12 bg-gray-300 rounded-full"></div>

                <h1 class="text-4xl font-bold">
                    CODIA-SYNC
                </h1>

            </div>

        </div>

        {{-- TITLE --}}
        <div class="bg-gray-300 p-6">

            <h1 class="text-5xl font-bold">
                Kelola Divisi.
            </h1>

        </div>

        {{-- MAIN --}}
        <div class="p-5">

            {{-- MAP --}}
            <div class="bg-gray-300 rounded-lg h-64 flex items-center justify-center">

                <h1 class="text-3xl font-bold">
                    Maps Google
                </h1>

            </div>

            {{-- FILTER --}}
            <div class="flex flex-wrap gap-5 mt-5 items-center">

                <input type="text"
                    placeholder="Pencarian.."
                    class="bg-gray-300 px-4 py-3 rounded-lg w-64 outline-none">

                <button
                    class="bg-gray-300 px-10 py-3 rounded-lg shadow text-2xl font-semibold hover:bg-gray-400">

                    Filter
                </button>

                <div class="ml-auto flex gap-5">

                    <button
                        class="bg-gray-300 px-10 py-3 rounded-lg shadow text-2xl font-semibold hover:bg-gray-400">

                        + Tambah Divisi
                    </button>

                    <button
                        class="bg-gray-300 px-10 py-3 rounded-lg shadow text-2xl font-semibold hover:bg-gray-400">

                        Atur Lokasi
                    </button>

                </div>

            </div>

            {{-- TABLE --}}
            <div class="mt-5 border border-black overflow-x-auto bg-white">

                <table class="w-full border-collapse">

                    <thead class="bg-gray-300">

                        <tr>

                            <th class="border border-black px-4 py-3 text-left">No</th>
                            <th class="border border-black px-4 py-3 text-left">Nip</th>
                            <th class="border border-black px-4 py-3 text-left">Nama</th>
                            <th class="border border-black px-4 py-3 text-left">Divisi</th>
                            <th class="border border-black px-4 py-3 text-left">Jabatan</th>
                            <th class="border border-black px-4 py-3 text-left">Jam Masuk</th>
                            <th class="border border-black px-4 py-3 text-left">Jam Keluar</th>
                            <th class="border border-black px-4 py-3 text-left">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($data as $item)

                        <tr>

                            <td class="border border-black px-4 py-3">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border border-black px-4 py-3">
                                {{ $item->nip }}
                            </td>

                            <td class="border border-black px-4 py-3">
                                {{ $item->nama }}
                            </td>

                            <td class="border border-black px-4 py-3">
                                {{ $item->divisi }}
                            </td>

                            <td class="border border-black px-4 py-3">
                                {{ $item->jabatan }}
                            </td>

                            <td class="border border-black px-4 py-3">
                                {{ $item->jam_masuk }}
                            </td>

                            <td class="border border-black px-4 py-3">
                                {{ $item->jam_keluar }}
                            </td>

                            <td class="border border-black px-4 py-3">

                                <div class="flex gap-2">

                                    <button
                                        class="bg-yellow-300 px-4 py-1 rounded">

                                        Edit
                                    </button>

                                    <button
                                        class="bg-red-400 px-4 py-1 rounded text-white">

                                        Hapus
                                    </button>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8"
                                class="border border-black text-center py-40 text-gray-500">

                                Data kosong

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>