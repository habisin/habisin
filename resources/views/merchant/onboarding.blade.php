<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">

        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            🎉 Buat Toko Pertamamu di HabisIn
        </h1>

        <p class="text-gray-600 mb-8">
            Sebelum mulai menjual makanan, lengkapi informasi dasar toko kamu.
        </p>

        <form action="{{ route('merchant.onboarding.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Nama Toko --}}
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">Nama Toko</label>
                <input type="text" id="name" name="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Ceritakan tentang toko kamu...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label for="address" class="block font-medium text-sm text-gray-700">Alamat</label>
                <input type="text" id="address" name="address"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ old('address') }}" required>
                @error('address')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- MAP PICKER --}}
            <div>
                <label class="block font-medium text-sm text-gray-700 mb-2">
                    Pin Lokasi Toko
                </label>

                <div id="map" class="w-full h-64 rounded-md shadow"></div>

                <p class="text-xs text-gray-500 mt-2">
                    Klik pada peta untuk memilih lokasi toko.
                </p>
            </div>

            {{-- Koordinat Lokasi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="latitude" class="block font-medium text-sm text-gray-700">Latitude</label>
                    <input type="text" id="latitude" name="latitude"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('latitude') }}" required readonly>
                </div>

                <div>
                    <label for="longitude" class="block font-medium text-sm text-gray-700">Longitude</label>
                    <input type="text" id="longitude" name="longitude"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('longitude') }}" required readonly>
                </div>
            </div>

            {{-- Logo Toko --}}
            <div>
                <label for="logo" class="block font-medium text-sm text-gray-700">Logo Toko</label>
                <input type="file" id="logo" name="logo"
                    class="mt-2 block w-full text-sm text-gray-700 border-gray-300 rounded-md cursor-pointer focus:ring-indigo-500 focus:border-indigo-500">
                <p class="text-xs text-gray-500 mt-1">
                    Format: JPG/PNG. Rekomendasi ratio 1:1.
                </p>
            </div>

            {{-- Submit --}}
            <div class="pt-4">
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Simpan & Mulai Jual
                </button>
            </div>
        </form>
    </div>

    {{-- Leaflet CSS & JS --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity=""
        crossorigin=""
    />
    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity=""
        crossorigin=""
    ></script>

    <script>
        const map = L.map("map").setView([-6.2000, 106.8166], 13); // Default Jakarta

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
        }).addTo(map);

        let marker;

        map.on("click", function (e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map);

            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
        });

        // Set map marker if old values exist
        @if(old('latitude') && old('longitude'))
            marker = L.marker([{{ old('latitude') }}, {{ old('longitude') }}]).addTo(map);
            map.setView([{{ old('latitude') }}, {{ old('longitude') }}], 15);
        @endif
    </script>

</x-app-layout>
