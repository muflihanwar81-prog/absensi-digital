<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Divisi</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    
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
<body class="bg-slate-50 text-slate-900 font-sans selection:bg-blue-600 selection:text-white">

<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <div class="flex-1 min-w-0">
        <!-- Header -->
        @include('components.header_admin')

        <!-- Judul -->
        <div class="px-6 pt-6">
            <div class="bg-white border border-slate-200/80 rounded-2xl px-6 py-6 shadow-sm">
                <p class="text-blue-600 font-semibold uppercase tracking-wider text-xs mb-1">Manajemen Divisi</p>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Kelola Divisi</h1>
                <p class="text-slate-500 mt-1.5 text-sm">Atur divisi, jam kerja, dan lokasi absensi perusahaan</p>
            </div>
        </div>

        <div class="p-6">
            <!-- Maps -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 mb-6 overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 text-slate-800">
                    <h3 class="font-extrabold text-base flex items-center gap-2">📍 Peta Lokasi Absensi Kantor Pusat</h3>
                    <p class="text-slate-500 text-xs mt-1">Titik pusat dan area radius absensi kantor pusat (berlaku untuk semua divisi)</p>
                </div>
                <div id="main-map" class="h-80 w-full"></div>
            </div>

            <!-- Filter dan Button -->
            <div class="flex flex-wrap gap-4 items-center mb-6">
                <input type="text" placeholder="Pencarian..."
                    class="bg-white border border-slate-200 shadow-sm px-4 py-2 rounded-xl text-sm outline-none text-slate-700 placeholder-slate-400 focus:border-blue-500 transition-all duration-200 w-72">

                <button
                    class="bg-white border border-slate-200 shadow-sm px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Filter
                </button>

                <div class="ml-auto flex gap-3">
                    <button type="button" onclick="openModalTambahDivisi()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm shadow-blue-500/10 hover:scale-[1.02] transition-all">
                        + Tambah Divisi
                    </button>

                    <button type="button" onclick="openModalAturLokasi()"
                        class="bg-white border border-slate-200 shadow-sm px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Atur Lokasi
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200/80">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3.5 text-left font-semibold">No</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Nama Divisi</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Jam Masuk</th>
                                <th class="px-6 py-3.5 text-left font-semibold">Jam Keluar</th>
                                <th class="px-6 py-3.5 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr class="border-t border-slate-100 hover:bg-slate-50/70 text-slate-700 text-sm transition duration-150">
                                <td class="px-6 py-4 font-mono font-medium text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $item->nama_divisi }}</td>
                                <td class="px-6 py-4 font-mono font-medium text-slate-650">{{ $item->jam_masuk }}</td>
                                <td class="px-6 py-4 font-mono font-medium text-slate-650">{{ $item->jam_keluar }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-3.5">
                                        <button type="button"
                                            onclick="openModalEditDivisi('{{ $item->id }}', '{{ addslashes($item->nama_divisi) }}', '{{ $item->jam_masuk }}', '{{ $item->jam_keluar }}')"
                                            class="bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20 px-3.5 py-1.5 rounded-xl font-semibold text-xs hover:bg-amber-100 transition">Edit</button>
                                        <form action="{{ route('admin.keloladivisi.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus divisi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20 px-3.5 py-1.5 rounded-xl font-semibold text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-20 text-slate-400 italic text-sm">
                                    Data divisi kosong
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Divisi -->
<div id="modalTambahDivisi"
    class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-[9999]" style="z-index: 9999;">
    <div class="bg-white w-[500px] rounded-2xl shadow-xl overflow-hidden border border-slate-200">
        <div class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-800 tracking-tight">Tambah Divisi</h2>
            <button type="button" onclick="closeModalTambahDivisi()" class="text-slate-400 hover:text-slate-600 text-2xl leading-none">&times;</button>
        </div>

        <form action="{{ route('admin.divisi.store') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold text-slate-600 text-xs uppercase tracking-wider col-span-1">Nama Divisi</label>
                    <input type="text" name="nama_divisi" required placeholder="Contoh: IT"
                        class="col-span-3 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none shadow-sm">
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold text-slate-600 text-xs uppercase tracking-wider col-span-1">Jam Masuk</label>
                    <input type="time" name="jam_masuk" required
                        class="col-span-3 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none shadow-sm text-slate-600">
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold text-slate-600 text-xs uppercase tracking-wider col-span-1">Jam Keluar</label>
                    <input type="time" name="jam_keluar" required
                        class="col-span-3 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none shadow-sm text-slate-600">
                </div>
            </div>

            <div class="border-t border-slate-200/60 mt-6 pt-4.5 flex gap-3">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-semibold text-sm transition shadow-sm shadow-blue-500/10">
                    Simpan Divisi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Divisi -->
<div id="modalEditDivisi"
    class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-[9999]" style="z-index: 9999;">
    <div class="bg-white w-[500px] rounded-2xl shadow-xl overflow-hidden border border-slate-200">
        <div class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-800 tracking-tight">Edit Divisi</h2>
            <button type="button" onclick="closeModalEditDivisi()" class="text-slate-400 hover:text-slate-600 text-2xl leading-none">&times;</button>
        </div>

        <form id="formEditDivisi" action="" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold text-slate-600 text-xs uppercase tracking-wider col-span-1">Nama Divisi</label>
                    <input type="text" id="edit_nama_divisi" name="nama_divisi" required placeholder="Contoh: IT"
                        class="col-span-3 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none shadow-sm">
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold text-slate-600 text-xs uppercase tracking-wider col-span-1">Jam Masuk</label>
                    <input type="time" id="edit_jam_masuk" name="jam_masuk" required
                        class="col-span-3 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none shadow-sm text-slate-600">
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold text-slate-600 text-xs uppercase tracking-wider col-span-1">Jam Keluar</label>
                    <input type="time" id="edit_jam_keluar" name="jam_keluar" required
                        class="col-span-3 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none shadow-sm text-slate-600">
                </div>
            </div>

            <div class="border-t border-slate-200/60 mt-6 pt-4.5 flex gap-3">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-semibold text-sm transition shadow-sm shadow-blue-500/10">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Atur Lokasi -->
<div id="modalAturLokasi"
    class="fixed inset-0 backdrop-blur-sm bg-slate-900/40 hidden items-center justify-center z-[9999]" style="z-index: 9999;">
    <div class="bg-white w-[650px] rounded-2xl shadow-xl overflow-hidden border border-slate-200">
        <div class="bg-slate-50 border-b border-slate-200/80 px-6 py-4 flex items-center justify-between text-slate-800">
            <h2 class="text-base font-bold text-slate-800 tracking-tight">Pengaturan Lokasi Kantor</h2>
            <button type="button" onclick="closeModalAturLokasi()" class="text-slate-400 hover:text-slate-600 text-2xl leading-none">&times;</button>
        </div>

        <form action="{{ route('admin.divisi.lokasi') }}" method="POST" class="p-6">
            @csrf

            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2.5">Lokasi GPS Kantor Pusat</label>
                <div class="bg-slate-100 rounded-xl overflow-hidden border border-slate-200">
                    <div id="map" class="rounded-xl h-72"></div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mt-4.5">
                <div>
                    <label class="block text-xxs font-bold text-slate-500 uppercase tracking-wider mb-2">Longitude</label>
                    <input type="text" id="longitude" name="longitude" value="{{ $globalLongitude }}"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none shadow-sm focus:border-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-xxs font-bold text-slate-500 uppercase tracking-wider mb-2">Latitude</label>
                    <input type="text" id="latitude" name="latitude" value="{{ $globalLatitude }}"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none shadow-sm focus:border-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-xxs font-bold text-slate-500 uppercase tracking-wider mb-2">Radius (Meter)</label>
                    <input type="number" id="radius" name="radius" value="{{ $globalRadius }}" min="1"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none shadow-sm focus:border-blue-500"
                        required>
                </div>
            </div>

            <div class="border-t border-slate-200/60 mt-6 pt-4.5">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl shadow-sm shadow-blue-500/10 font-semibold text-sm hover:shadow-md transition">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
let mainMap;
let map;
let marker;
let circle;

// Fix Leaflet marker icon path issue globally
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
});

function initMainMap() {
    const mainMapElement = document.getElementById('main-map');
    if (!mainMapElement) return;

    const lat = parseFloat("{{ $globalLatitude }}") || -6.200000;
    const lng = parseFloat("{{ $globalLongitude }}") || 106.816666;
    const radius = parseInt("{{ $globalRadius }}") || 100;
    const defaultCenter = [lat, lng];

    mainMap = L.map('main-map').setView(defaultCenter, 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(mainMap);

    // Add Marker
    const m = L.marker(defaultCenter).addTo(mainMap);
    m.bindPopup(`
        <div style="font-family: sans-serif; font-size: 14px; padding: 5px;">
            <h4 style="margin: 0 0 8px 0; font-weight: 800; color: #2563eb; font-size: 15px;">🏢 Lokasi Kantor Pusat</h4>
            <div style="color: #475569; display: flex; flex-direction: column; gap: 4px;">
                <div><b>Latitude:</b> <code style="background: #f1f5f9; padding: 2px 4px; border-radius: 4px;">${lat}</code></div>
                <div><b>Longitude:</b> <code style="background: #f1f5f9; padding: 2px 4px; border-radius: 4px;">${lng}</code></div>
                <div><b>Radius:</b> <span style="font-weight: bold; color: #10b981;">${radius} meter</span></div>
            </div>
        </div>
    `);

    // Add Circle
    L.circle(defaultCenter, {
        color: '#2563eb',
        fillColor: '#3b82f6',
        fillOpacity: 0.25,
        radius: radius
    }).addTo(mainMap);
}

function initMap() {
    const lat = parseFloat(document.getElementById('latitude').value) || -6.200000;
    const lng = parseFloat(document.getElementById('longitude').value) || 106.816666;
    const defaultLocation = [lat, lng];
    const mapElement = document.getElementById('map');
    if (!mapElement) return;

    map = L.map('map').setView(defaultLocation, 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    marker = L.marker(defaultLocation, {
        draggable: true
    }).addTo(map);

    const initialRadius = parseInt(document.getElementById('radius').value) || 100;
    circle = L.circle(defaultLocation, {
        color: '#ef4444',
        fillColor: '#ef4444',
        fillOpacity: 0.2,
        radius: initialRadius
    }).addTo(map);

    updateCoordinateInputs(defaultLocation[0], defaultLocation[1]);

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        circle.setLatLng(e.latlng);
        updateCoordinateInputs(e.latlng.lat, e.latlng.lng);
    });

    marker.on('dragend', function() {
        const position = marker.getLatLng();
        circle.setLatLng(position);
        updateCoordinateInputs(position.lat, position.lng);
    });
}

function updateCoordinateInputs(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(6);
    document.getElementById('longitude').value = lng.toFixed(6);
}

function moveMarkerFromInput() {
    if (!map || !marker) return;
    const lat = parseFloat(document.getElementById('latitude').value);
    const lng = parseFloat(document.getElementById('longitude').value);
    if (isNaN(lat) || isNaN(lng)) return;
    const pos = [lat, lng];
    marker.setLatLng(pos);
    if (circle) circle.setLatLng(pos);
    map.setView(pos, map.getZoom());
}

function openModalTambahDivisi() {
    const modal = document.getElementById('modalTambahDivisi');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

// Close Modal with backdrop
document.addEventListener('click', function (e) {
    const modalTambah = document.getElementById('modalTambahDivisi');
    const modalAtur    = document.getElementById('modalAturLokasi');
    const modalEdit    = document.getElementById('modalEditDivisi');
    if (modalTambah && e.target === modalTambah) closeModalTambahDivisi();
    if (modalAtur    && e.target === modalAtur)    closeModalAturLokasi();
    if (modalEdit    && e.target === modalEdit)    closeModalEditDivisi();
});

// Close Modal with ESC
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeModalTambahDivisi(); closeModalAturLokasi(); closeModalEditDivisi(); }
});

// Edit Divisi Modal
function openModalEditDivisi(id, namaDivisi, jamMasuk, jamKeluar) {
    document.getElementById('edit_nama_divisi').value = namaDivisi || '';
    document.getElementById('edit_jam_masuk').value    = jamMasuk   || '';
    document.getElementById('edit_jam_keluar').value   = jamKeluar  || '';
    document.getElementById('formEditDivisi').action   = '/keloladivisi/' + id;

    const modal = document.getElementById('modalEditDivisi');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModalEditDivisi() {
    const modal = document.getElementById('modalEditDivisi');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

function closeModalTambahDivisi() {
    const modal = document.getElementById('modalTambahDivisi');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function openModalAturLokasi() {
    const modal = document.getElementById('modalAturLokasi');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        if (!map) {
            initMap();
        } else {
            map.invalidateSize();
            if (marker) map.setView(marker.getLatLng(), map.getZoom());
        }
    }, 300);
}

function closeModalAturLokasi() {
    const modal = document.getElementById('modalAturLokasi');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.addEventListener('DOMContentLoaded', function() {
    initMainMap();

    document.getElementById('latitude')?.addEventListener('change', moveMarkerFromInput);
    document.getElementById('longitude')?.addEventListener('change', moveMarkerFromInput);
    
    document.getElementById('radius')?.addEventListener('input', function() {
        if (circle) {
            circle.setRadius(parseInt(this.value) || 100);
        }
    });
});
</script>

</body>
</html>
