<x-app-layout>
<div class="max-w-3xl mx-auto py-10">

    <h1 class="text-2xl font-bold text-gray-900 mb-6">
        <i class="fa-solid fa-store"></i> Edit Informasi Toko
    </h1>

    <form action="{{ route('merchant.shop.update') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @method('PUT')

        {{-- PREVIEW LOGO --}}
        <div>
            <label class="block font-medium mb-2">Logo Toko Saat Ini</label>

            <img id="logoPreview"
                 src="{{ $shop->logo ? Storage::url($shop->logo) : asset('images/no_image.jpg') }}"
                 class="w-32 h-32 object-cover rounded-lg border mb-3">

            <input type="file"
                   name="logo"
                   accept="image/*"
                   onchange="previewLogo(event)"
                   class="block w-full text-sm border rounded-md">

            <p class="text-xs text-gray-500 mt-1">
                Format JPG / PNG, ratio 1:1 disarankan.
            </p>
        </div>

        {{-- NAMA --}}
        <div>
            <label class="block text-sm font-medium">Nama Toko</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $shop->name) }}"
                   class="mt-1 w-full border rounded-md px-3 py-2"
                   required>
        </div>

        {{-- DESKRIPSI --}}
        <div>
            <label class="block text-sm font-medium">Deskripsi</label>
            <textarea name="description"
                      rows="4"
                      class="mt-1 w-full border rounded-md px-3 py-2">{{ old('description', $shop->description) }}</textarea>
        </div>

        {{-- ALAMAT --}}
        <div>
            <label class="block text-sm font-medium">Alamat</label>
            <input type="text"
                   name="address"
                   value="{{ old('address', $shop->address) }}"
                   class="mt-1 w-full border rounded-md px-3 py-2"
                   required>
        </div>

        {{-- MAP --}}
        <div>
            <label class="block text-sm font-medium mb-2">Lokasi Toko</label>
            <div id="map" class="w-full h-64 rounded shadow"></div>
            <p class="text-xs text-gray-500 mt-1">
                Klik peta untuk ubah lokasi toko.
            </p>
        </div>

        {{-- COORDINATE --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm">Latitude</label>
                <input type="text"
                       id="latitude"
                       name="latitude"
                       class="w-full border rounded p-2"
                       value="{{ old('latitude', $shop->latitude) }}"
                       readonly required>
            </div>

            <div>
                <label class="block text-sm">Longitude</label>
                <input type="text"
                       id="longitude"
                       name="longitude"
                       class="w-full border rounded p-2"
                       value="{{ old('longitude', $shop->longitude) }}"
                       readonly required>
            </div>
        </div>

        {{-- STATUS --}}
        <div class="flex items-center gap-3">
            <input type="checkbox"
                   name="is_active"
                   id="is_active"
                   {{ $shop->is_active ? 'checked' : '' }}>
            <label for="is_active" class="text-sm">
                Toko Aktif
            </label>
        </div>

        {{-- BUTTON --}}
        <div class="flex gap-3 pt-4">
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                <i class="fa-solid fa-save"></i> Simpan Perubahan
            </button>

            <a href="{{ route('merchant.dashboard') }}"
               class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </a>
        </div>

    </form>

</div>
</x-app-layout>

<script>
function previewLogo(event) {
    const img = document.getElementById('logoPreview');
    img.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<link rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
const lat = {{ old('latitude', $shop->latitude) }};
const lng = {{ old('longitude', $shop->longitude) }};

const map = L.map("map").setView([lat, lng], 15);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19
}).addTo(map);

let marker = L.marker([lat, lng]).addTo(map);

map.on("click", function (e) {
    const lat = e.latlng.lat;
    const lng = e.latlng.lng;

    marker.setLatLng([lat, lng]);

    document.getElementById("latitude").value = lat;
    document.getElementById("longitude").value = lng;
});
</script>

