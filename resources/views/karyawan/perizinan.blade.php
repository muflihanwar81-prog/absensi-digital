{{-- resources/views/karyawan/perizinan.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengajuan Izin</title>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 font-sans">

    <div class="flex min-h-screen">

        {{-- Sidebar Karyawan --}}
        @include('layouts.sidebar_karyawan')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">

            {{-- HEADER --}}
            @include('components.header')

            {{-- CONTENT --}}
            <main class="flex-1 p-8">

                {{-- ALERT SUCCESS --}}
                @if (session('success'))
                    <div
                        class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ALERT ERROR --}}
                @if ($errors->any())
                    <div
                        class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-6 py-4 rounded-2xl shadow-sm">
                        <ul class="list-disc ml-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- BUTTON TAMBAH IZIN --}}
                <div class="flex justify-end mb-6">
                    <button
                        onclick="openModal()"
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-2xl font-bold shadow-xl hover:shadow-2xl hover:scale-105 transition duration-300">
                        + Ajukan Izin
                    </button>
                </div>

                {{-- CARD UTAMA --}}
                <div class="bg-white rounded-3xl shadow-2xl border border-blue-100 overflow-hidden">

                    {{-- HEADER CARD --}}
                    <div
                        class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-8 py-8 text-white">
                        <p class="text-sm uppercase tracking-[0.3em] font-semibold opacity-90 mb-2">
                            Permission Request
                        </p>
                        <h2 class="text-4xl font-black tracking-tight">
                            Pengajuan Izin
                        </h2>
                        <p class="text-blue-100 mt-2 text-lg">
                            Kelola dan pantau seluruh pengajuan izin Anda.
                        </p>
                    </div>

                    <div class="p-8">

                        {{-- TABLE --}}
                        <div
                            class="bg-white rounded-3xl border border-blue-100 shadow-xl overflow-hidden">

                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse">

                                    {{-- TABLE HEADER --}}
                                    <thead
                                        class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm uppercase tracking-wider">
                                        <tr>
                                            <th class="px-4 py-4 text-center font-bold">No</th>
                                            <th class="px-4 py-4 text-left font-bold">NIP</th>
                                            <th class="px-4 py-4 text-left font-bold">Nama Karyawan</th>
                                            <th class="px-4 py-4 text-left font-bold">Divisi</th>
                                            <th class="px-4 py-4 text-left font-bold">Jabatan</th>
                                            <th class="px-4 py-4 text-left font-bold">Jenis Izin</th>
                                            <th class="px-4 py-4 text-center font-bold">Status</th>
                                            <th class="px-4 py-4 text-center font-bold">Aksi</th>
                                        </tr>
                                    </thead>

                                    {{-- TABLE BODY --}}
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse ($data as $item)
                                            <tr
                                                class="hover:bg-blue-50/60 transition duration-200">

                                                <td
                                                    class="px-4 py-4 text-center font-semibold text-slate-700">
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td
                                                    class="px-4 py-4 font-mono text-sm text-slate-600">
                                                    {{ $item->nip }}
                                                </td>

                                                <td
                                                    class="px-4 py-4 font-semibold text-slate-800">
                                                    {{ $item->nama }}
                                                </td>

                                                <td class="px-4 py-4 text-slate-700">
                                                    {{ $item->divisi }}
                                                </td>

                                                <td class="px-4 py-4 text-slate-700">
                                                    {{ $item->jabatan }}
                                                </td>

                                                <td class="px-4 py-4 text-slate-700">
                                                    {{ $item->kategori }}
                                                </td>

                                                <td class="px-4 py-4 text-center">
                                                    <span
                                                        class="px-3 py-1 rounded-full text-xs font-bold
                                                        @if ($item->status == 'Disetujui')
                                                            bg-emerald-100 text-emerald-700
                                                        @elseif($item->status == 'Ditolak')
                                                            bg-rose-100 text-rose-700
                                                        @else
                                                            bg-amber-100 text-amber-700
                                                        @endif">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>

                                                <td class="px-4 py-4 text-center">
                                                    @if ($item->file_tambahan)
                                                        <a
                                                            href="{{ asset('storage/' . $item->file_tambahan) }}"
                                                            target="_blank"
                                                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100 text-blue-700 hover:bg-blue-200 transition duration-200">
                                                            👁
                                                        </a>
                                                    @else
                                                        <span class="text-slate-400">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td
                                                    colspan="8"
                                                    class="text-center py-24 text-slate-400 italic text-lg">
                                                    Belum ada pengajuan izin.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>

                        </div>

                    </div>
                </div>

            </main>

        </div>

    </div>

    {{-- MODAL AJUKAN IZIN --}}
    <div
        id="modalIzin"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">

        <div
            class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl border border-blue-100 overflow-hidden">

            {{-- HEADER MODAL --}}
            <div
                class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-8 py-6 text-white flex justify-between items-center">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] font-semibold opacity-90 mb-1">
                        New Request
                    </p>
                    <h2 class="text-3xl font-black tracking-tight">
                        Ajukan Izin
                    </h2>
                </div>

                <button
                    onclick="closeModal()"
                    class="w-10 h-10 rounded-xl bg-white/20 hover:bg-white/30 flex items-center justify-center text-2xl font-light transition duration-200">
                    ×
                </button>
            </div>

            {{-- FORM --}}
            <form
                action="{{ route('izin.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="p-8 space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        NIP
                    </label>
                    <input
                        type="text"
                        value="{{ $karyawan->nip }}"
                        readonly
                        class="w-full bg-slate-100 border border-blue-100 rounded-2xl px-4 py-3 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Nama
                    </label>
                    <input
                        type="text"
                        value="{{ $karyawan->nama }}"
                        readonly
                        class="w-full bg-slate-100 border border-blue-100 rounded-2xl px-4 py-3 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Divisi
                    </label>
                    <input
                        type="text"
                        value="{{ $karyawan->divisi }}"
                        readonly
                        class="w-full bg-slate-100 border border-blue-100 rounded-2xl px-4 py-3 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Jabatan
                    </label>
                    <input
                        type="text"
                        value="{{ $karyawan->jabatan }}"
                        readonly
                        class="w-full bg-slate-100 border border-blue-100 rounded-2xl px-4 py-3 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Kategori
                    </label>
                    <select
                        name="kategori"
                        required
                        class="w-full bg-white border border-blue-100 rounded-2xl px-4 py-3 outline-none focus:ring-4 focus:ring-blue-100 shadow-sm">
                        <option value="">Pilih Kategori</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                        <option value="Cuti">Cuti</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        File Tambahan
                    </label>
                    <input
                        type="file"
                        name="file_tambahan"
                        class="w-full bg-white border border-blue-100 rounded-2xl px-4 py-3 outline-none shadow-sm">
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-2xl font-bold shadow-xl hover:shadow-2xl transition duration-300">
                    Kirim Pengajuan
                </button>
            </form>

        </div>
    </div>

    {{-- SCRIPT MODAL --}}
    <script>
        function openModal() {
            document.getElementById('modalIzin').classList.remove('hidden');
            document.getElementById('modalIzin').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modalIzin').classList.add('hidden');
            document.getElementById('modalIzin').classList.remove('flex');
        }

        // Tutup modal saat klik area gelap
        document.getElementById('modalIzin').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>

</body>

</html>