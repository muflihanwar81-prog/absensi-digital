{{-- resources/views/karyawan/perizinan.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Izin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-200">

<div class="flex min-h-screen">

    @include('layouts.partials.sidebar_karyawan')

    <div class="flex-1">

        <div class="bg-[#efefef] border-b border-gray-400">
            <div class="flex items-center justify-between px-6 py-3">
                <h1 class="text-3xl font-bold text-gray-800">
                    Presensia
                </h1>

                <div class="text-sm font-medium text-gray-700">
                    Hallo, {{ session('karyawan_nama', 'Karyawan') }}
                </div>
            </div>
        </div>

        <div class="p-6">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-12 gap-6">

                <div class="col-span-8">
                    <div class="bg-white border border-gray-400 rounded-lg shadow-sm p-6">

                        <div class="bg-gray-200 rounded-lg px-6 py-4 mb-6 flex justify-between items-center">
                            <h2 class="text-4xl font-bold text-gray-800">
                                Pengajuan Izin
                            </h2>
                        </div>

                        <div class="border border-gray-400 overflow-x-auto">
                            <table class="w-full border-collapse text-sm">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="border border-gray-400 px-3 py-2">No</th>
                                        <th class="border border-gray-400 px-3 py-2">NIK</th>
                                        <th class="border border-gray-400 px-3 py-2">Nama Karyawan</th>
                                        <th class="border border-gray-400 px-3 py-2">Divisi</th>
                                        <th class="border border-gray-400 px-3 py-2">Jabatan</th>
                                        <th class="border border-gray-400 px-3 py-2">Jenis Izin</th>
                                        <th class="border border-gray-400 px-3 py-2">Status</th>
                                        <th class="border border-gray-400 px-3 py-2">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($data as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-400 px-3 py-2 text-center">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="border border-gray-400 px-3 py-2">
                                                {{ $item->nip }}
                                            </td>

                                            <td class="border border-gray-400 px-3 py-2">
                                                {{ $item->nama }}
                                            </td>

                                            <td class="border border-gray-400 px-3 py-2">
                                                {{ $item->divisi }}
                                            </td>

                                            <td class="border border-gray-400 px-3 py-2">
                                                {{ $item->jabatan }}
                                            </td>

                                            <td class="border border-gray-400 px-3 py-2">
                                                {{ $item->kategori }}
                                            </td>

                                            <td class="border border-gray-400 px-3 py-2">
                                                {{ $item->status }}
                                            </td>

                                            <td class="border border-gray-400 px-3 py-2 text-center">
                                                @if ($item->file_tambahan)
                                                    <a href="{{ asset('storage/' . $item->file_tambahan) }}"
                                                       target="_blank"
                                                       class="bg-gray-300 hover:bg-gray-400 px-2 py-1 rounded">
                                                        👁
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8"
                                                class="border border-gray-400 text-center py-20 text-gray-500">
                                                Belum ada pengajuan izin.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="col-span-4">
                    <div class="bg-white border border-gray-400 rounded-lg shadow-sm p-6">

                        <div class="bg-gray-200 rounded-lg px-6 py-4 mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">
                                Pengajuan Izin
                            </h2>
                        </div>

                        <form action="{{ route('izin.store') }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-semibold mb-1">NIP</label>
                                <input type="text"
                                       value="{{ $karyawan->nip }}"
                                       readonly
                                       class="w-full border border-gray-400 rounded px-3 py-2 bg-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1">Nama</label>
                                <input type="text"
                                       value="{{ $karyawan->nama }}"
                                       readonly
                                       class="w-full border border-gray-400 rounded px-3 py-2 bg-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1">Divisi</label>
                                <input type="text"
                                       value="{{ $karyawan->divisi }}"
                                       readonly
                                       class="w-full border border-gray-400 rounded px-3 py-2 bg-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1">Jabatan</label>
                                <input type="text"
                                       value="{{ $karyawan->jabatan }}"
                                       readonly
                                       class="w-full border border-gray-400 rounded px-3 py-2 bg-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1">Kategori</label>
                                <select name="kategori"
                                        required
                                        class="w-full border border-gray-400 rounded px-3 py-2">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Cuti">Cuti</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1">File Tambahan</label>
                                <input type="file"
                                       name="file_tambahan"
                                       class="w-full border border-gray-400 rounded px-3 py-2">
                            </div>

                            <button type="submit"
                                    class="w-full bg-gray-700 hover:bg-gray-800 text-white py-2 rounded font-semibold">
                                Kirim
                            </button>

                        </form>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>