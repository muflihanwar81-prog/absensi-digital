<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Divisi</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100">

<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <div class="flex-1">
        <!-- Header -->
        @include('components.header_admin')

        <!-- Judul -->
        <div class="bg-white border-b border-blue-100 px-6 py-6 shadow-sm">
            <p class="text-blue-600 font-semibold uppercase tracking-widest text-sm mb-2">Manajemen Divisi</p>
            <h1 class="text-5xl font-extrabold text-slate-800 tracking-tight">Kelola Divisi</h1>
            <p class="text-slate-500 mt-2 text-lg">Atur divisi, jam kerja, dan lokasi absensi perusahaan.</p>
        </div>

        <div class="p-6">
            <!-- Maps -->
            <div class="bg-white rounded-3xl shadow-2xl border border-blue-100 mb-6 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 text-white">
                    <h3 class="font-extrabold text-xl flex items-center gap-2">📍 Peta Lokasi Absensi Divisi</h3>
                    <p class="text-blue-100 text-sm mt-1">Titik pusat dan area radius absensi untuk masing-masing divisi yang telah diatur</p>
                </div>
                <div id="main-map" class="h-80 w-full"></div>
            </div>

            <!-- Filter dan Button -->
            <div class="flex flex-wrap gap-5 items-center mb-6">
                <input type="text" placeholder="Pencarian..."
                    class="bg-white border border-blue-100 shadow-lg px-5 py-3 rounded-2xl w-72 outline-none text-slate-700 placeholder-slate-400">

                <button
                    class="bg-white border border-blue-100 shadow-lg px-8 py-3 rounded-2xl text-xl font-bold text-slate-700 hover:shadow-xl transition">
                    Filter
                </button>

                <div class="ml-auto flex gap-5">
                    <button type="button" onclick="openModalTambahDivisi()"
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-2xl shadow-xl text-xl font-bold hover:shadow-2xl transition">
                        + Tambah Divisi
                    </button>

                    <button type="button" onclick="openModalAturLokasi()"
                        class="bg-white border border-blue-100 shadow-lg px-8 py-3 rounded-2xl text-xl font-bold text-slate-700 hover:shadow-xl transition">
                        Atur Lokasi
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-2xl border border-blue-100">
                <table class="w-full border-collapse">
                    <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-lg font-bold">
                        <tr>
                            <th class="px-4 py-4 text-left">No</th>
                            <th class="px-4 py-4 text-left">Nama Divisi</th>
                            <th class="px-4 py-4 text-left">Jam Masuk</th>
                            <th class="px-4 py-4 text-left">Jam Keluar</th>
                            <th class="px-4 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                        <tr class="border-t border-slate-100 hover:bg-blue-50 transition">
                            <td class="px-4 py-4">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 font-semibold text-slate-800">{{ $item->nama_divisi }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $item->jam_masuk }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $item->jam_keluar }}</td>
                            <td class="px-4 py-4">
                                <div class="flex gap-3">
                                    <button class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl font-semibold">Edit</button>
                                    <form action="{{ route('admin.keloladivisi.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus divisi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-100 text-red-700 px-4 py-2 rounded-xl font-semibold">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-20 text-slate-400 italic text-xl">
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

<!-- Modal Tambah Divisi -->
<div id="modalTambahDivisi"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[9999]" style="z-index: 9999;">
    <div class="bg-white w-[600px] rounded-3xl shadow-2xl overflow-hidden border border-blue-100">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 text-white">
            <h2 class="text-3xl font-extrabold">Tambah Divisi</h2>
        </div>

        <form action="{{ route('admin.divisi.store') }}" method="POST" class="p-8">
            @csrf
            <div class="space-y-6">
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold text-slate-700">Nama Divisi</label>
                    <input type="text" name="nama_divisi" required
                        class="col-span-3 bg-slate-100 border border-blue-100 rounded-2xl px-4 py-3 outline-none">
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold text-slate-700">Jam Masuk</label>
                    <input type="time" name="jam_masuk" required
                        class="col-span-3 bg-slate-100 border border-blue-100 rounded-2xl px-4 py-3 outline-none">
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="font-bold text-slate-700">Jam Keluar</label>
                    <input type="time" name="jam_keluar" required
                        class="col-span-3 bg-slate-100 border border-blue-100 rounded-2xl px-4 py-3 outline-none">
                </div>
            </div>

            <div class="border-t border-slate-200 mt-8 pt-6 flex gap-4">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-2xl font-bold text-xl">
                    Simpan Divisi
                </button>
                <button type="button" onclick="closeModalTambahDivisi()"
                    class="bg-red-500 text-white px-6 rounded-2xl font-bold">
                    X
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Atur Lokasi -->
<div id="modalAturLokasi"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[9999]" style="z-index: 9999;">
    <div class="bg-white w-[650px] rounded-3xl shadow-2xl overflow-hidden border border-blue-100">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between text-white">
            <h2 class="text-3xl font-extrabold">Pengaturan Lokasi</h2>
            <button type="button" onclick="closeModalAturLokasi()" class="text-4xl leading-none">×</button>
        </div>

        <form action="{{ route('admin.divisi.lokasi') }}" method="POST" class="p-6">
            @csrf

            <div class="mb-4">
                <label class="block text-lg font-bold text-slate-700 mb-3">Pilih Divisi</label>
                <select name="divisi_id" required class="w-full bg-slate-100 border border-blue-100 rounded-2xl px-4 py-3 text-lg outline-none shadow-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-200">
                    <option value="" disabled selected>-- Pilih Divisi --</option>
                    @foreach ($data as $divisi)
                        <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-xl font-bold text-slate-800 mb-3">Lokasi GPS</label>
                <div class="bg-slate-100 rounded-2xl overflow-hidden shadow-inner border border-blue-100">
                    <div id="map" class="rounded-2xl h-72"></div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 mt-6">
                <div>
                    <label class="block text-lg font-bold text-slate-700 mb-3">Longitude</label>
                    <input type="text" id="longitude" name="longitude"
                        class="w-full bg-slate-100 border border-blue-100 rounded-2xl px-4 py-3 text-lg outline-none shadow-sm"
                        required>
                </div>
                <div>
                    <label class="block text-lg font-bold text-slate-700 mb-3">Latitude</label>
                    <input type="text" id="latitude" name="latitude"
                        class="w-full bg-slate-100 border border-blue-100 rounded-2xl px-4 py-3 text-lg outline-none shadow-sm"
                        required>
                </div>
                <div>
                    <label class="block text-lg font-bold text-slate-700 mb-3">Radius (Meter)</label>
                    <input type="number" id="radius" name="radius" value="100" min="1"
                        class="w-full bg-slate-100 border border-blue-100 rounded-2xl px-4 py-3 text-lg outline-none shadow-sm"
                        required>
                </div>
            </div>

            <div class="border-t border-slate-200 mt-8 pt-6">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-2xl shadow-xl font-bold text-xl hover:shadow-2xl transition">
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
const divisiData = @json($data);

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

    const divisionsWithLocation = divisiData.filter(d => d.latitude && d.longitude);

    let defaultCenter = [-6.200000, 106.816666]; // Default Jakarta
    let zoomLevel = 13;

    if (divisionsWithLocation.length > 0) {
        defaultCenter = [parseFloat(divisionsWithLocation[0].latitude), parseFloat(divisionsWithLocation[0].longitude)];
        zoomLevel = 15;
    }

    mainMap = L.map('main-map').setView(defaultCenter, zoomLevel);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(mainMap);

    const bounds = [];

    divisionsWithLocation.forEach(divisi => {
        const lat = parseFloat(divisi.latitude);
        const lng = parseFloat(divisi.longitude);
        const radius = parseInt(divisi.radius) || 100;
        const pos = [lat, lng];

        bounds.push(pos);

        // Add Marker
        const m = L.marker(pos).addTo(mainMap);
        m.bindPopup(`
            <div style="font-family: sans-serif; font-size: 14px; padding: 5px;">
                <h4 style="margin: 0 0 8px 0; font-weight: 800; color: #2563eb; font-size: 15px;">🏢 Divisi: ${divisi.nama_divisi}</h4>
                <div style="color: #475569; display: flex; flex-direction: column; gap: 4px;">
                    <div><b>Latitude:</b> <code style="background: #f1f5f9; padding: 2px 4px; border-radius: 4px;">${lat}</code></div>
                    <div><b>Longitude:</b> <code style="background: #f1f5f9; padding: 2px 4px; border-radius: 4px;">${lng}</code></div>
                    <div><b>Radius:</b> <span style="font-weight: bold; color: #10b981;">${radius} meter</span></div>
                </div>
            </div>
        `);

        // Add Circle
        L.circle(pos, {
            color: '#2563eb',
            fillColor: '#3b82f6',
            fillOpacity: 0.25,
            radius: radius
        }).addTo(mainMap);
    });

    if (bounds.length > 1) {
        mainMap.fitBounds(bounds, { padding: [50, 50] });
    }
}

function initMap() {
    const defaultLocation = [-6.200000, 106.816666];
    const mapElement = document.getElementById('map');
    if (!mapElement) return;

    map = L.map('map').setView(defaultLocation, 15);

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

    document.querySelector('select[name="divisi_id"]')?.addEventListener('change', function() {
        const selectedId = this.value;
        const divisi = divisiData.find(d => d.id == selectedId);
        if (divisi && divisi.latitude && divisi.longitude) {
            const pos = [parseFloat(divisi.latitude), parseFloat(divisi.longitude)];
            const rad = parseInt(divisi.radius) || 100;
            
            document.getElementById('latitude').value = pos[0].toFixed(6);
            document.getElementById('longitude').value = pos[1].toFixed(6);
            document.getElementById('radius').value = rad;
            
            if (marker && map) {
                marker.setLatLng(pos);
                if (circle) {
                    circle.setLatLng(pos);
                    circle.setRadius(rad);
                }
                map.setView(pos, 16);
            }
        }
    });
});
</script>

</body>
</html>
