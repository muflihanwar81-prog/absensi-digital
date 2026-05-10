<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Divisi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-200">

    <div class="flex min-h-screen">

        @include('layouts.sidebar')

        <div class="flex-1">

            <div class="bg-[#efefef] border-b">
                <div class="flex items-center gap-5 px-6 py-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full"></div>

                    <h1 class="text-4xl font-bold">
                        CODIA-SYNC
                    </h1>
                </div>
            </div>

            <div class="bg-gray-300 p-6">
                <h1 class="text-5xl font-bold">
                    Kelola Divisi.
                </h1>
            </div>

            <div class="p-5">

                {{-- MAP / LOKASI --}}
                <div class="bg-gray-300 rounded-lg h-64 flex items-center justify-center">
                    <h1 class="text-3xl font-bold text-gray-700">
                        Maps Google
                    </h1>
                </div>

                {{-- FILTER DAN BUTTON --}}
                <div class="flex flex-wrap gap-5 mt-5 items-center">

                    <input
                        type="text"
                        placeholder="Pencarian.."
                        class="bg-gray-300 px-4 py-3 rounded-lg w-64 outline-none">

                    <button
                        class="bg-gray-300 px-10 py-3 rounded-lg shadow text-2xl font-semibold hover:bg-gray-400">
                        Filter
                    </button>

                    <div class="ml-auto flex gap-5">

                        {{-- BUTTON TAMBAH DIVISI --}}
                        <button
                            type="button"
                            onclick="openModalTambahDivisi()"
                            class="bg-gray-300 px-10 py-3 rounded-lg shadow text-2xl font-semibold hover:bg-gray-400">
                            + Tambah Divisi
                        </button>

                        {{-- BUTTON ATUR LOKASI --}}
                        <button
                            type="button"
                            onclick="openModalAturLokasi()"
                            class="bg-gray-300 px-10 py-3 rounded-lg shadow text-2xl font-semibold hover:bg-gray-400">
                            Atur Lokasi
                        </button>

                    </div>

                </div>

                {{-- TABLE --}}
                <div class="mt-5 border border-black overflow-x-auto bg-white">

                    <table class="w-full border-collapse">

                        <thead class="bg-gray-300">
                            <tr>
                                <th class="border border-black px-4 py-3 text-left">No</th>
                                <th class="border border-black px-4 py-3 text-left">Nama Divisi</th>
                                <th class="border border-black px-4 py-3 text-left">Jam Masuk</th>
                                <th class="border border-black px-4 py-3 text-left">Jam Keluar</th>
                                <th class="border border-black px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td class="border border-black px-4 py-3">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border border-black px-4 py-3">
                                    {{ $item->nama_divisi }}
                                </td>

                                <td class="border border-black px-4 py-3">
                                    {{ $item->jam_masuk }}
                                </td>

                                <td class="border border-black px-4 py-3">
                                    {{ $item->jam_keluar }}
                                </td>

                                <td class="border border-black px-4 py-3">
                                    <div class="flex gap-2">

                                        <button
                                            class="bg-yellow-300 px-4 py-1 rounded">
                                            Edit
                                        </button>

                                        <form
                                            action="{{ route('admin.keloladivisi.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus divisi ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="bg-red-400 px-4 py-1 rounded text-white">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td
                                    colspan="5"
                                    class="border border-black text-center py-20 text-gray-500">
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

    {{-- MODAL TAMBAH DIVISI --}}
    <div
        id="modalTambahDivisi"
        class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50">

        <div class="bg-gray-200 w-[600px] rounded-lg shadow-lg overflow-hidden">

            <div class="bg-gray-300 px-6 py-4 border-b border-gray-400">
                <h2 class="text-3xl font-bold">Tambah Divisi</h2>
            </div>

            <form
                action="{{ route('admin.divisi.store') }}"
                method="POST"
                class="p-8">
                @csrf

                <div class="space-y-6">

                    <div class="grid grid-cols-4 items-center gap-4">
                        <label class="font-bold">Nama Divisi</label>
                        <input
                            type="text"
                            name="nama_divisi"
                            required
                            class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none">
                    </div>

                    <div class="grid grid-cols-4 items-center gap-4">
                        <label class="font-bold">Jam Masuk</label>
                        <input
                            type="time"
                            name="jam_masuk"
                            required
                            class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none">
                    </div>

                    <div class="grid grid-cols-4 items-center gap-4">
                        <label class="font-bold">Jam Keluar</label>
                        <input
                            type="time"
                            name="jam_keluar"
                            required
                            class="col-span-3 bg-gray-300 rounded px-4 py-3 outline-none">
                    </div>

                </div>

                <div class="border-t border-gray-400 mt-8 pt-6 flex gap-4">

                    <button
                        type="submit"
                        class="w-full bg-gray-300 hover:bg-gray-400 py-3 rounded font-bold text-xl">
                        Simpan Divisi
                    </button>

                    <button
                        type="button"
                        onclick="closeModalTambahDivisi()"
                        class="bg-red-400 hover:bg-red-500 text-white px-6 rounded font-bold">
                        X
                    </button>

                </div>
            </form>

        </div>
    </div>

    {{-- MODAL ATUR LOKASI --}}
<div
    id="modalAturLokasi"
    class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50">

    <div class="bg-gray-200 w-[500px] rounded-lg shadow-xl overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-gray-300 px-6 py-4 flex items-center justify-between border-b border-gray-400">
            <h2 class="text-3xl font-bold">
                Pengaturan Lokasi
            </h2>

            <button
                type="button"
                onclick="closeModalAturLokasi()"
                class="text-4xl leading-none font-light hover:text-red-500">
                ×
            </button>
        </div>

        {{-- FORM --}}
        <form
            action="{{ route('admin.lokasi.store') }}"
            method="POST"
            class="p-6">
            @csrf

            {{-- LABEL MAP --}}
            <div class="mb-4">
                <label class="block text-2xl font-bold mb-3">
                    Lokasi GPS
                </label>

                {{-- AREA MAP --}}
    <div class="bg-gray-300 rounded-lg h-48 overflow-hidden shadow-inner">
    <div
    id="map"
    class="rounded-lg h-64 border border-gray-400 shadow-inner">
</div>
    </iframe>
</div>
</div>
            </div>

            {{-- INPUT KOORDINAT --}}
            <div class="grid grid-cols-2 gap-6 mt-6">

                <div>
        <label class="block text-2xl font-bold mb-3">
            Longitude
        </label>
        <input
            type="text"
            id="longitude"
            name="longitude"
            class="w-full bg-gray-300 rounded-lg px-4 py-3 text-xl outline-none shadow"
            required>
    </div>

    <div>
        <label class="block text-2xl font-bold mb-3">
            Latitude
        </label>
        <input
            type="text"
            id="latitude"
            name="latitude"
            class="w-full bg-gray-300 rounded-lg px-4 py-3 text-xl outline-none shadow"
            required>
    </div>


            </div>

            {{-- INPUT TAMBAHAN --}}
            <input
                type="hidden"
                name="nama_lokasi"
                value="Kantor Pusat">

            <input
                type="hidden"
                name="radius"
                value="100">

            {{-- FOOTER --}}
            <div class="border-t border-gray-400 mt-8 pt-6">
                <button
                    type="submit"
                    class="w-full bg-gray-300 hover:bg-gray-400 py-3 rounded-lg shadow font-bold text-2xl">
                    Simpan Data
                </button>
            </div>
        </form>

    </div>
</div>
{{-- TEMPATKAN SCRIPT INI DI BAGIAN PALING BAWAH SEBELUM </body> --}}

<script>
    let map;
    let marker;

    // Inisialisasi Google Maps
    function initMap() {
        const defaultLocation = {
            lat: -6.200000,
            lng: 106.816666
        };

        const mapElement = document.getElementById('map');
        if (!mapElement) return;

        // Membuat peta
        map = new google.maps.Map(mapElement, {
            center: defaultLocation,
            zoom: 15,
            mapTypeId: 'roadmap'
        });

        // Membuat marker yang bisa digeser
        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP
        });

        // Isi input default
        updateCoordinateInputs(defaultLocation.lat, defaultLocation.lng);

        // Klik di peta untuk memilih lokasi
        map.addListener('click', function (event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();

            marker.setPosition(event.latLng);
            updateCoordinateInputs(lat, lng);
        });

        // Geser marker
        marker.addListener('dragend', function (event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();

            updateCoordinateInputs(lat, lng);
        });
    }

    // Update input latitude dan longitude
    function updateCoordinateInputs(lat, lng) {
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        if (latitudeInput) {
            latitudeInput.value = lat.toFixed(6);
        }

        if (longitudeInput) {
            longitudeInput.value = lng.toFixed(6);
        }
    }

    // Pindahkan marker saat input diubah manual
    function moveMarkerFromInput() {
        if (!map || !marker) return;

        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);

        if (isNaN(lat) || isNaN(lng)) return;

        const newPosition = {
            lat: lat,
            lng: lng
        };

        marker.setPosition(newPosition);
        map.setCenter(newPosition);
    }

    // Modal Tambah Divisi
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

    // Modal Atur Lokasi
    function openModalAturLokasi() {
        const modal = document.getElementById('modalAturLokasi');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Tunggu modal tampil lalu render map
        setTimeout(() => {
            if (!map) {
                initMap();
            } else {
                google.maps.event.trigger(map, 'resize');

                if (marker) {
                    map.setCenter(marker.getPosition());
                }
            }
        }, 300);
    }

    function closeModalAturLokasi() {
        const modal = document.getElementById('modalAturLokasi');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Event saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function () {
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        if (latitudeInput) {
            latitudeInput.addEventListener('change', moveMarkerFromInput);
        }

        if (longitudeInput) {
            longitudeInput.addEventListener('change', moveMarkerFromInput);
        }
    });
</script>

{{-- GOOGLE MAPS API --}}
<script
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"
    async
    defer>
</script>  

</body>

</html>