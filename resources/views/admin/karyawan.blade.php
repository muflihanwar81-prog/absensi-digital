<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan - Dashboard Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-[#efefef] flex font-sans overflow-hidden">

    @include('layouts.sidebar')

    {{-- GANTI BAGIAN INI --}}
    <main class="flex-1 h-screen overflow-y-auto">
        @include('layouts.header', ['title' => 'Data Karyawan'])

        <div class="p-6">
            <div class="w-full mx-auto px-4 lg:px-6">
                {{-- HEADER CARD --}}
                <div class="bg-[#d9d9d9] rounded-xl p-6 mb-5 shadow-sm">
                    <div class="flex justify-between items-start">
                        <h1 class="text-5xl font-black text-black">Data Karyawan</h1>

                        <button onclick="openModal()"
                            class="bg-white hover:bg-gray-100 shadow-md px-6 py-3 rounded-lg font-bold text-3xl flex items-center gap-3 mt-4">
                            <span class="text-3xl leading-none">+</span>
                            <span class="text-2xl">Tambah Karyawan</span>
                        </button>
                    </div>

                    {{-- STATISTIK DIVISI --}}
                    <div class="grid grid-cols-4 gap-4 mt-8 text-gray-800">
                        @forelse($daftarDivisi as $divisi)
                        <div class="text-center bg-white/40 rounded-lg py-4">
                            <p class="text-xs font-bold uppercase mb-2">
                                {{ $divisi }}
                            </p>
                            <h2 class="text-4xl font-black">
                                {{ \App\Models\Karyawan::where('divisi', $divisi)->count() }}
                            </h2>
                        </div>
                        @empty
                        <div class="col-span-4 text-center text-gray-500 italic py-8">
                            Belum ada data divisi
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- SEARCH & FILTER --}}
                <div class="flex gap-4 items-center mb-6">
                    <form action="{{ route('admin.karyawan') }}"
                        method="GET"
                        class="flex-1 flex gap-4 items-center">

                        {{-- SEARCH --}}
                        <div class="flex-1">
                            <div class="bg-[#d9d9d9] rounded-lg px-5 py-3 flex items-center gap-4">
                                <i class="fa-solid fa-magnifying-glass text-2xl text-black"></i>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari nik dan nama karyawan.."
                                    class="w-full bg-transparent outline-none text-xl font-medium">
                            </div>
                        </div>

                        {{-- FILTER DIVISI --}}
                        <select
                            name="divisi"
                            onchange="this.form.submit()"
                            class="bg-[#d9d9d9] shadow px-6 py-3 rounded-lg font-bold text-xl outline-none">
                            <option value="">Semua Divisi</option>
                            @foreach($daftarDivisi as $divisi)
                            <option value="{{ $divisi }}"
                                {{ request('divisi') == $divisi ? 'selected' : '' }}>
                                {{ $divisi }}
                            </option>
                            @endforeach
                        </select>

                        {{-- FILTER JABATAN --}}
                        <select
                            name="jabatan"
                            onchange="this.form.submit()"
                            class="bg-[#d9d9d9] shadow px-6 py-3 rounded-lg font-bold text-xl outline-none">
                            <option value="">Semua Jabatan</option>
                            @foreach(\App\Models\Karyawan::select('jabatan')->distinct()->pluck('jabatan') as $jabatan)
                            <option value="{{ $jabatan }}"
                                {{ request('jabatan') == $jabatan ? 'selected' : '' }}>
                                {{ $jabatan }}
                            </option>
                            @endforeach
                        </select>

                        {{-- FILTER STATUS --}}
                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="bg-[#d9d9d9] shadow px-6 py-3 rounded-lg font-bold text-xl outline-none">
                            <option value="">Semua Status</option>
                            <option value="Aktif"
                                {{ request('status') == 'Aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="Nonaktif"
                                {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>
                    </form>
                </div>

                {{-- TABEL --}}
                <div class="bg-[#efefef] border border-gray-500 rounded-xl overflow-hidden min-h-[480px]">
                    <table class="w-full border-collapse">
                        <thead class="bg-[#d9d9d9] text-black font-bold text-xl">
                            <tr>
                                <th class="px-4 py-4 text-left">No</th>
                                <th class="px-4 py-4 text-left">Nik</th>
                                <th class="px-4 py-4 text-left">Nama Karyawan</th>
                                <th class="px-4 py-4 text-left">Divisi</th>
                                <th class="px-4 py-4 text-left">Jabatan</th>
                                <th class="px-4 py-4 text-left">Status</th>
                                <th class="px-4 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($karyawans as $index => $k)
                            <tr class="border-t border-gray-300 hover:bg-gray-100 text-lg">
                                <td class="px-4 py-4">{{ $index + 1 }}</td>
                                <td class="px-4 py-4">{{ $k->nip }}</td>
                                <td class="px-4 py-4">{{ $k->nama }}</td>
                                <td class="px-4 py-4">{{ $k->divisi }}</td>
                                <td class="px-4 py-4">{{ $k->jabatan }}</td>
                                <td class="px-4 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-bold
                                        {{ $k->status == 'Aktif'
                                            ? 'bg-green-200 text-green-700'
                                            : 'bg-orange-200 text-orange-700' }}">
                                        {{ $k->status }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <div class="flex justify-center gap-4 text-xl">

                                        <a href="#" class="hover:text-blue-600">
                                            <i class="fa-solid fa-camera"></i>
                                        </a>

                                        <button type="button"
        onclick="openEditModal(
            '{{ $k->id }}',
            '{{ $k->nip }}',
            '{{ $k->nama }}',
            '{{ $k->divisi }}',
            '{{ $k->jabatan }}'
        )"
        class="hover:text-blue-600">
    <i class="fa-solid fa-pen-to-square"></i>
</button>

                                        <form action="{{ route('admin.karyawan.destroy', $k->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="hover:text-red-600">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7"
                                    class="h-[400px] text-center text-gray-400 italic text-xl">
                                    Belum ada data tersedia
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>

    <div id="modalTambah"
        class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50">
        <div class="bg-gray-200 w-[700px] rounded shadow-lg overflow-hidden">

            <div class="bg-gray-300 px-6 py-4 border-b border-gray-400">
                <h2 class="text-3xl font-black">Tambah Data Karyawan</h2>
            </div>

            <form action="{{ route('admin.karyawan.store') }}"
                method="POST"
                class="p-8">
                @csrf

                <div class="space-y-6">
    <div class="grid grid-cols-4 items-center gap-4">
        <label class="font-bold">NIP</label>
        <input type="text"
               name="nip"
               class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none"
               required>
    </div>

    <div class="grid grid-cols-4 items-center gap-4">
        <label class="font-bold">Nama</label>
        <input type="text"
               name="nama"
               class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none"
               required>
    </div>

    <div class="grid grid-cols-4 items-center gap-4">
        <label class="font-bold">Email</label>
        <input type="email"
               name="email"
               class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none"
               required>
    </div>

    <div class="grid grid-cols-4 items-center gap-4">
        <label class="font-bold">Password</label>
        <input type="password"
               name="password"
               class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none"
               required>
    </div>

    <div class="grid grid-cols-4 items-center gap-4">
        <label class="font-bold">Divisi</label>
        <select name="divisi"
                class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none"
                required>
            <option value="">Pilih Divisi</option>

            @foreach($daftarDivisi as $divisi)
                <option value="{{ $divisi }}">
                    {{ $divisi }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-4 items-center gap-4">
        <label class="font-bold">Jabatan</label>
        <input type="text"
               name="jabatan"
               class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none"
               required>
    </div>
</div>

                <div class="border-t border-gray-400 mt-10 pt-6 flex gap-4">
                    <button type="submit"
                        class="w-full bg-gray-300 hover:bg-gray-400 py-3 rounded font-bold text-xl">
                        Simpan Data
                    </button>

                    <button type="button"
                        onclick="closeModal()"
                        class="bg-red-400 hover:bg-red-500 text-white px-6 rounded font-bold">
                        X
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- MODAL EDIT -->
<div id="modalEdit"
     class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50">
    <div class="bg-gray-200 w-[700px] rounded shadow-lg overflow-hidden">

        <div class="bg-gray-300 px-6 py-4 border-b border-gray-400">
            <h2 class="text-3xl font-black">Edit Data Karyawan</h2>
        </div>

        <form id="formEdit"
              method="POST"
              class="p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold">NIP</label>
                    <input type="text"
                           name="nip"
                           id="edit_nip"
                           class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none"
                           required>
                </div>

                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold">Nama</label>
                    <input type="text"
                           name="nama"
                           id="edit_nama"
                           class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none"
                           required>
                </div>

                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold">Divisi</label>
                    <select name="divisi"
                            id="edit_divisi"
                            class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none"
                            required>
                        @foreach($daftarDivisi as $divisi)
                            <option value="{{ $divisi }}">
                                {{ $divisi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold">Jabatan</label>
                    <input type="text"
                           name="jabatan"
                           id="edit_jabatan"
                           class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none"
                           required>
                </div>
            </div>

            <div class="border-t border-gray-400 mt-10 pt-6 flex gap-4">
                <button type="submit"
                        class="w-full bg-gray-300 hover:bg-gray-400 py-3 rounded font-bold text-xl">
                    Update Data
                </button>

                <button type="button"
                        onclick="closeEditModal()"
                        class="bg-red-400 hover:bg-red-500 text-white px-6 rounded font-bold">
                    X
                </button>
            </div>
        </form>
    </div>
</div>
    <script>
        function openModal() {
            document.getElementById('modalTambah').classList.remove('hidden');
            document.getElementById('modalTambah').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modalTambah').classList.add('hidden');
            document.getElementById('modalTambah').classList.remove('flex');
        }
        function openEditModal(id, nip, nama, divisi, jabatan) {
    document.getElementById('edit_nip').value = nip;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_divisi').value = divisi;
    document.getElementById('edit_jabatan').value = jabatan;

    document.getElementById('formEdit').action =
        '/admin/karyawan/' + id;

    document.getElementById('modalEdit').classList.remove('hidden');
    document.getElementById('modalEdit').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('modalEdit').classList.add('hidden');
    document.getElementById('modalEdit').classList.remove('flex');
}
    </script>
</body>

</html>