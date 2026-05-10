<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Karyawan - Dashboard Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 flex font-sans overflow-hidden">

    @include('layouts.sidebar')

    <main class="flex-1 h-screen overflow-y-auto">
        @include('layouts.header', ['title' => 'Data Karyawan'])

        <div class="p-6">
            <div class="w-full mx-auto px-4 lg:px-6">

                {{-- HEADER CARD --}}
                <div class="bg-white rounded-xl p-6 mb-5 shadow-xl border border-blue-100">
                    <div class="flex justify-between items-start">
                        <h1 class="text-5xl font-black text-slate-800">
                            Data Karyawan
                        </h1>

                        <button onclick="openModal()"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl px-6 py-3 rounded-lg font-bold text-3xl flex items-center gap-3 mt-4 transition duration-300">
                            <span class="text-3xl leading-none">+</span>
                            <span class="text-2xl">Tambah Karyawan</span>
                        </button>
                    </div>

                    {{-- STATISTIK DIVISI --}}
                    <div class="grid grid-cols-4 gap-4 mt-8 text-gray-800">
                        @forelse($daftarDivisi as $divisi)
                        <div class="text-center bg-blue-50 border border-blue-100 rounded-lg py-4 shadow-sm">
                            <p class="text-xs font-bold uppercase mb-2 text-slate-500">
                                {{ $divisi }}
                            </p>
                            <h2 class="text-4xl font-black text-blue-700">
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
                            <div class="bg-white border border-blue-100 rounded-lg px-5 py-3 flex items-center gap-4 shadow-md">
                                <i class="fa-solid fa-magnifying-glass text-2xl text-blue-600"></i>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari NIP dan nama karyawan..."
                                    class="w-full bg-transparent outline-none text-xl font-medium text-slate-700 placeholder-slate-400">
                            </div>
                        </div>

                        {{-- FILTER DIVISI --}}
                        <select
                            name="divisi"
                            onchange="this.form.submit()"
                            class="bg-white border border-blue-100 shadow-md px-6 py-3 rounded-lg font-bold text-xl outline-none text-slate-700">
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
                            class="bg-white border border-blue-100 shadow-md px-6 py-3 rounded-lg font-bold text-xl outline-none text-slate-700">
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
                            class="bg-white border border-blue-100 shadow-md px-6 py-3 rounded-lg font-bold text-xl outline-none text-slate-700">
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
                <div class="bg-white border border-blue-100 rounded-xl overflow-hidden min-h-[480px] shadow-xl">
                    <table class="w-full border-collapse">
                        <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xl">
                            <tr>
                                <th class="px-4 py-4 text-left">No</th>
                                <th class="px-4 py-4 text-left">NIP</th>
                                <th class="px-4 py-4 text-left">Nama Karyawan</th>
                                <th class="px-4 py-4 text-left">Divisi</th>
                                <th class="px-4 py-4 text-left">Jabatan</th>
                                <th class="px-4 py-4 text-left">Status</th>
                                <th class="px-4 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($karyawans as $index => $k)
                            <tr class="border-t border-slate-200 hover:bg-blue-50 text-lg transition duration-200">
                                <td class="px-4 py-4">{{ $index + 1 }}</td>
                                <td class="px-4 py-4">{{ $k->nip }}</td>
                                <td class="px-4 py-4">{{ $k->nama }}</td>
                                <td class="px-4 py-4">{{ $k->divisi }}</td>
                                <td class="px-4 py-4">{{ $k->jabatan }}</td>
                                <td class="px-4 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-bold
                                        {{ $k->status == 'Aktif'
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-orange-100 text-orange-700' }}">
                                        {{ $k->status }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <div class="flex justify-center gap-4 text-xl">

                                        <a href="#" class="text-slate-500 hover:text-blue-600 transition">
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
                                            class="text-slate-500 hover:text-blue-600 transition">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <form action="{{ route('admin.karyawan.destroy', $k->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="text-slate-500 hover:text-red-600 transition">
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
<script>
    // =========================
    // MODAL TAMBAH KARYAWAN
    // =========================
    function openModal() {
        const modalTambah = document.getElementById('modalTambah');

        if (modalTambah) {
            modalTambah.classList.remove('hidden');
            modalTambah.classList.add('flex');
        }
    }

    function closeModal() {
        const modalTambah = document.getElementById('modalTambah');

        if (modalTambah) {
            modalTambah.classList.add('hidden');
            modalTambah.classList.remove('flex');
        }
    }

    // =========================
    // MODAL EDIT KARYAWAN
    // =========================
    function openEditModal(id, nip, nama, divisi, jabatan) {
        // Isi form edit
        document.getElementById('edit_nip').value = nip;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_divisi').value = divisi;
        document.getElementById('edit_jabatan').value = jabatan;

        // Set action form update
        document.getElementById('formEdit').action = '/admin/karyawan/' + id;

        // Tampilkan modal edit
        const modalEdit = document.getElementById('modalEdit');

        if (modalEdit) {
            modalEdit.classList.remove('hidden');
            modalEdit.classList.add('flex');
        }
    }

    function closeEditModal() {
        const modalEdit = document.getElementById('modalEdit');

        if (modalEdit) {
            modalEdit.classList.add('hidden');
            modalEdit.classList.remove('flex');
        }
    }

    // =========================
    // TUTUP MODAL SAAT KLIK AREA GELAP
    // =========================
    document.addEventListener('click', function (e) {
        const modalTambah = document.getElementById('modalTambah');
        const modalEdit = document.getElementById('modalEdit');

        // Tutup modal tambah
        if (modalTambah && e.target === modalTambah) {
            closeModal();
        }

        // Tutup modal edit
        if (modalEdit && e.target === modalEdit) {
            closeEditModal();
        }
    });

    // =========================
    // TUTUP MODAL DENGAN TOMBOL ESC
    // =========================
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
            closeEditModal();
        }
    });
</script>
</body>

</html>