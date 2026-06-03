

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengajuan Izin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    
    <link rel="preconnect" href="https:
    <link rel="preconnect" href="https:
    <link href="https:
    <link rel="stylesheet" href="https:
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 flex font-sans h-screen overflow-hidden selection:bg-blue-600 selection:text-white">

    <div class="flex min-h-screen w-full">

        
        @include('layouts.sidebar_karyawan')

        
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">

            
            @include('components.header')

            
            <main class="flex-1 p-6">

                
                @if (session('success'))
                    <div
                        class="mb-6 bg-emerald-50 border border-emerald-255 text-emerald-700 px-5 py-3.5 rounded-xl shadow-sm text-sm font-semibold flex items-center gap-2">
                        <span>✅</span> <span>{{ session('success') }}</span>
                    </div>
                @endif

                
                @if ($errors->any())
                    <div
                        class="mb-6 bg-rose-50 border border-rose-255 text-rose-700 px-5 py-3.5 rounded-xl shadow-sm text-sm">
                        <ul class="list-disc ml-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                
                <div class="flex justify-end mb-6">
                    <button
                        onclick="openModal()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm shadow-blue-500/10 hover:scale-[1.02] transition-all">
                        + Ajukan Izin
                    </button>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

                    
                    <div class="bg-slate-50 border-b border-slate-200/80 px-8 py-5 text-slate-800">
                        <p class="uppercase tracking-wider text-xxs font-bold text-slate-400 mb-1">
                            Permission Request
                        </p>
                        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                            Pengajuan Izin
                        </h2>
                        <p class="mt-1 text-slate-500 text-sm">
                            Kelola dan pantau seluruh pengajuan izin Anda.
                        </p>
                    </div>

                    <div class="p-6">

                        
                        <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden">

                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse">

                                    
                                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                                        <tr>
                                            <th class="px-6 py-3.5 text-left font-semibold">No</th>
                                            <th class="px-6 py-3.5 text-left font-semibold">NIP</th>
                                            <th class="px-6 py-3.5 text-left font-semibold">Nama Karyawan</th>
                                            <th class="px-6 py-3.5 text-left font-semibold">Divisi</th>
                                            <th class="px-6 py-3.5 text-left font-semibold">Jabatan</th>
                                            <th class="px-6 py-3.5 text-left font-semibold">Jenis Izin</th>
                                            <th class="px-6 py-3.5 text-center font-semibold">Status</th>
                                            <th class="px-6 py-3.5 text-center font-semibold">Aksi</th>
                                        </tr>
                                    </thead>

                                    
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse ($data as $item)
                                            <tr class="hover:bg-slate-50/70 text-slate-700 text-sm transition duration-150">

                                                <td class="px-6 py-4 font-mono font-medium text-slate-500 text-center">
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td class="px-6 py-4 font-mono font-semibold text-slate-800">
                                                    {{ $item->nip }}
                                                </td>

                                                <td class="px-6 py-4 font-bold text-slate-800">
                                                    {{ $item->nama }}
                                                </td>

                                                <td class="px-6 py-4">
                                                    {{ $item->divisi }}
                                                </td>

                                                <td class="px-6 py-4">
                                                    {{ $item->jabatan }}
                                                </td>

                                                <td class="px-6 py-4 font-semibold text-slate-850">
                                                    {{ $item->kategori }}
                                                </td>

                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                                        @if ($item->status == 'Disetujui')
                                                            bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20
                                                        @elseif($item->status == 'Ditolak')
                                                            bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20
                                                        @else
                                                            bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20
                                                        @endif">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>

                                                <td class="px-6 py-4 text-center">
                                                    @if ($item->file_tambahan)
                                                        <a
                                                            href="{{ asset('storage/' . $item->file_tambahan) }}"
                                                            target="_blank"
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/10 hover:bg-blue-100 transition">
                                                            <i class="fa-solid fa-eye text-xs"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-slate-400 font-medium">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td
                                                    colspan="8"
                                                    class="text-center py-24 text-slate-400 italic text-sm">
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

    
    <div
        id="modalIzin"
        class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-50 p-4">

        <div
            class="bg-white w-full max-w-lg rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

            
            <div
                class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 text-slate-800 flex justify-between items-center">
                <div>
                    <p class="text-xxs uppercase tracking-wider font-bold text-slate-400 mb-0.5">
                        New Request
                    </p>
                    <h2 class="text-base font-bold text-slate-800 tracking-tight">
                        Ajukan Izin
                    </h2>
                </div>

                <button
                    onclick="closeModal()"
                    class="text-slate-450 hover:text-slate-650 text-2xl font-bold leading-none">
                    &times;
                </button>
            </div>

            
            <form
                action="{{ route('izin.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                        NIP
                    </label>
                    <input
                        type="text"
                        value="{{ $karyawan->nip }}"
                        readonly
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-500 outline-none">
                </div>

                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                        Nama
                    </label>
                    <input
                        type="text"
                        value="{{ $karyawan->nama }}"
                        readonly
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                            Divisi
                        </label>
                        <input
                            type="text"
                            value="{{ $karyawan->divisi }}"
                            readonly
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-500 outline-none">
                    </div>

                    <div>
                        <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                            Jabatan
                        </label>
                        <input
                            type="text"
                            value="{{ $karyawan->jabatan }}"
                            readonly
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                        Kategori
                    </label>
                    <div class="relative">
                        <select
                            name="kategori"
                            required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none appearance-none cursor-pointer transition shadow-sm text-slate-700">
                            <option value="">Pilih Kategori</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Cuti">Cuti</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xxs"></i>
                    </div>
                </div>

                <div>
                    <label class="block mb-1.5 font-bold text-slate-500 text-xxs uppercase tracking-wider">
                        File Tambahan
                    </label>
                    <input
                        type="file"
                        name="file_tambahan"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none shadow-sm focus:border-blue-500 transition">
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-semibold text-sm transition shadow-sm shadow-blue-500/10">
                    Kirim Pengajuan
                </button>
            </form>

        </div>
    </div>

    
    <script>
        function openModal() {
            document.getElementById('modalIzin').classList.remove('hidden');
            document.getElementById('modalIzin').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modalIzin').classList.add('hidden');
            document.getElementById('modalIzin').classList.remove('flex');
        }

        
        document.getElementById('modalIzin').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>

</body>

</html>
