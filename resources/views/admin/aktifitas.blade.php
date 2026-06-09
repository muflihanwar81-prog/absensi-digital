<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Aktifitas - ADMIN</title>
    <link class="favicon" rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 flex font-sans overflow-hidden">

    {{-- Sidebar navigasi admin --}}
    @include('layouts.sidebar')

    <main class="flex-1 h-screen overflow-y-auto">

        {{-- Header atas halaman admin --}}
        @include('components.header_admin')

        <div class="p-6">
            <div class="w-full mx-auto px-4 lg:px-6">

                {{-- HEADER CARD: Judul + total seluruh aktivitas (dari pagination) --}}
                <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm border border-slate-200/80">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <p class="text-blue-600 font-semibold uppercase tracking-wider text-xs mb-1">
                                Audit Trail
                            </p>
                            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                                Riwayat Aktifitas Admin
                            </h1>
                            <p class="text-slate-500 mt-1.5 text-sm">
                                Daftar seluruh tindakan dan perubahan data yang dilakukan oleh administrator.
                            </p>
                        </div>

                        {{-- Total aktivitas dari hasil paginasi --}}
                        <div class="bg-slate-50 border border-slate-200/60 rounded-xl px-5 py-3 shadow-sm text-center min-w-[160px]">
                            <p class="text-xxs font-bold uppercase tracking-wider text-slate-400 mb-1">
                                Total Aktifitas
                            </p>
                            <h2 class="text-2xl font-extrabold text-slate-800 font-mono">
                                {{ $activities->total() }} {{-- Total dari paginator --}}
                            </h2>
                        </div>
                    </div>
                </div>

                {{-- TIMELINE LIST: Tampilkan aktivitas sebagai timeline vertikal --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            {{-- Mapping warna ikon berdasarkan tipe aktivitas --}}
                            @php
                                $bgColors = [
                                    'blue'    => 'bg-blue-100',
                                    'amber'   => 'bg-amber-100',
                                    'rose'    => 'bg-rose-100',
                                    'purple'  => 'bg-purple-100',
                                    'emerald' => 'bg-emerald-100',
                                    'cyan'    => 'bg-cyan-100',
                                    'slate'   => 'bg-slate-100',
                                ];
                                $textColors = [
                                    'blue'    => 'text-blue-600',
                                    'amber'   => 'text-amber-600',
                                    'rose'    => 'text-rose-600',
                                    'purple'  => 'text-purple-600',
                                    'emerald' => 'text-emerald-600',
                                    'cyan'    => 'text-cyan-600',
                                    'slate'   => 'text-slate-600',
                                ];
                            @endphp

                            {{-- Loop setiap aktivitas admin dari $activities (paginated) --}}
                            @forelse($activities as $index => $activity)
                                @php
                                    // Tentukan warna latar dan teks ikon berdasarkan field 'warna' di database
                                    $bgColor   = $bgColors[$activity->warna]   ?? 'bg-slate-100';
                                    $textColor = $textColors[$activity->warna] ?? 'text-slate-600';
                                @endphp
                                <li>
                                    <div class="relative pb-8">
                                        {{-- Garis vertikal penghubung antar item timeline (sembunyikan di item terakhir) --}}
                                        @if(!$loop->last)
                                            <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                        @endif

                                        <div class="relative flex space-x-3">
                                            {{-- Ikon bulat dengan warna dinamis sesuai tipe aktivitas --}}
                                            <div>
                                                <span class="h-10 w-10 rounded-full {{ $bgColor }} flex items-center justify-center ring-8 ring-white shrink-0 shadow-sm">
                                                    <i class="fa-solid fa-{{ $activity->icon }} {{ $textColor }} text-sm"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    {{-- Judul aktivitas, misal: "Menambahkan Karyawan Baru" --}}
                                                    <p class="text-sm font-semibold text-slate-800">
                                                        {{ $activity->judul }}
                                                    </p>
                                                    {{-- Deskripsi detail aktivitas (opsional) --}}
                                                    @if($activity->deskripsi)
                                                        <p class="text-xs text-slate-500 mt-1 bg-slate-50 border border-slate-100 rounded-lg px-2.5 py-1.5 inline-block">
                                                            {{ $activity->deskripsi }}
                                                        </p>
                                                    @endif
                                                </div>
                                                {{-- Waktu aktivitas: jam dan tanggal --}}
                                                <div class="text-right text-xs whitespace-nowrap text-slate-500">
                                                    <time datetime="{{ $activity->created_at }}">
                                                        <span class="font-semibold block text-slate-700">
                                                            {{ $activity->created_at->format('H:i') }}
                                                        </span>
                                                        <span class="text-xxs text-slate-400">
                                                            {{ $activity->created_at->format('d M Y') }}
                                                        </span>
                                                    </time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                {{-- Tampilkan pesan jika belum ada aktivitas --}}
                                <div class="text-center py-20 text-slate-400 italic text-sm">
                                    <i class="fa-solid fa-clock-rotate-left text-4xl mb-3 block text-slate-300"></i>
                                    Belum ada aktifitas yang tercatat
                                </div>
                            @endforelse
                        </ul>
                    </div>

                    {{-- PAGINATION: Tampilkan navigasi halaman jika data lebih dari 1 halaman --}}
                    @if($activities->hasPages())
                        <div class="mt-8 border-t border-slate-100 pt-6">
                            {{ $activities->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </main>

</body>

</html>
