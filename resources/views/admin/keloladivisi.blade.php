<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Divisi</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
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
            <div class="bg-white rounded-3xl h-64 flex items-center justify-center shadow-2xl border border-blue-100 mb-6">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-3xl shadow-lg mb-4">
                        📍
                    </div>
                    <h1 class="text-3xl font-extrabold text-slate-800">Maps Google</h1>
                    <p class="text-slate-500 mt-2">Pengaturan lokasi absensi perusahaan</p>
                </div>
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
    class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50">
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
    class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white w-[650px] rounded-3xl shadow-2xl overflow-hidden border border-blue-100">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between text-white">
            <h2 class="text-3xl font-extrabold">Pengaturan Lokasi</h2>
            <button type="button" onclick="closeModalAturLokasi()" class="text-4xl leading-none">×</button>
        </div>

        <form action="{{ route('admin.lokasi.store') }}" method="POST" class="p-6">
            @csrf

            <div class="mb-4">
                <label class="block text-xl font-bold text-slate-800 mb-3">Lokasi GPS</label>
                <div class="bg-slate-100 rounded-2xl overflow-hidden shadow-inner border border-blue-100">
                    <div id="map" class="rounded-2xl h-72"></div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mt-6">
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
            </div>

            <input type="hidden" name="nama_lokasi" value="Kantor Pusat">
            <input type="hidden" name="radius" value="100">

            <div class="border-t border-slate-200 mt-8 pt-6">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-2xl shadow-xl font-bold text-xl">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let map;
let marker;

function initMap() {
    const defaultLocation = { lat: -6.200000, lng: 106.816666 };
    const mapElement = document.getElementById('map');
    if (!mapElement || typeof google === 'undefined') return;

    map = new google.maps.Map(mapElement, {
        center: defaultLocation,
        zoom: 15,
        mapTypeId: 'roadmap'
    });

    marker = new google.maps.Marker({
        position: defaultLocation,
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP
    });

    updateCoordinateInputs(defaultLocation.lat, defaultLocation.lng);

    map.addListener('click', function(event) {
        marker.setPosition(event.latLng);
        updateCoordinateInputs(event.latLng.lat(), event.latLng.lng());
    });

    marker.addListener('dragend', function(event) {
        updateCoordinateInputs(event.latLng.lat(), event.latLng.lng());
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
    const pos = { lat, lng };
    marker.setPosition(pos);
    map.setCenter(pos);
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
        } else if (typeof google !== 'undefined') {
            google.maps.event.trigger(map, 'resize');
            if (marker) map.setCenter(marker.getPosition());
        }
    }, 300);
}

function closeModalAturLokasi() {
    const modal = document.getElementById('modalAturLokasi');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('latitude')?.addEventListener('change', moveMarkerFromInput);
    document.getElementById('longitude')?.addEventListener('change', moveMarkerFromInput);
});
</script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"
    async
    defer>
</script>

</body>
</html>
