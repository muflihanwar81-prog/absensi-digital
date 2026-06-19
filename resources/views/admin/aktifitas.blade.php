<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Aktifitas - ADMIN</title>
    <link class="favicon" rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    
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

    
    @include('layouts.sidebar')

    <main class="flex-1 h-screen overflow-y-auto">

        
        @include('components.header_admin')

        <div class="p-6">
            <div class="w-full mx-auto px-4 lg:px-6">

                
                <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm border border-slate-200/80">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div class="animate-welcome-left">
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

                        
                        <div class="bg-slate-50 border border-slate-200/60 rounded-xl px-5 py-3 shadow-sm text-center min-w-[160px] animate-welcome-right">
                            <p class="text-xxs font-bold uppercase tracking-wider text-slate-400 mb-1">
                                Total Aktifitas
                            </p>
                            <h2 class="text-2xl font-extrabold text-slate-800 font-mono">
                                {{ $activities->total() }} 
                            </h2>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 animate-card delay-100">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            
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

                            
                            @forelse($activities as $index => $activity)
                                @php
                                    // Tentukan warna latar dan teks ikon berdasarkan field 'warna' di database
                                    $bgColor   = $bgColors[$activity->warna]   ?? 'bg-slate-100';
                                    $textColor = $textColors[$activity->warna] ?? 'text-slate-600';
                                @endphp
                                <li>
                                    <div class="relative pb-8">
                                        
                                        @if(!$loop->last)
                                            <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                        @endif

                                        <div class="relative flex space-x-3">
                                            
                                            <div>
                                                <span class="h-10 w-10 rounded-full {{ $bgColor }} flex items-center justify-center ring-8 ring-white shrink-0 shadow-sm">
                                                    <i class="fa-solid fa-{{ $activity->icon }} {{ $textColor }} text-sm"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    
                                                    <p class="text-sm font-semibold text-slate-800">
                                                        {{ $activity->judul }}
                                                    </p>
                                                    
                                                    @if($activity->deskripsi)
                                                        <p class="text-xs text-slate-500 mt-1 bg-slate-50 border border-slate-100 rounded-lg px-2.5 py-1.5 inline-block">
                                                            {{ $activity->deskripsi }}
                                                        </p>
                                                    @endif
                                                </div>
                                                
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
                                
                                <div class="text-center py-20 text-slate-400 italic text-sm">
                                    <i class="fa-solid fa-clock-rotate-left text-4xl mb-3 block text-slate-300"></i>
                                    Belum ada aktifitas yang tercatat
                                </div>
                            @endforelse
                        </ul>
                    </div>

                    
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
