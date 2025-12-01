<x-app-layout>
<div class="max-w-4xl mx-auto py-8">

    @if(!request('lat') || !request('lng'))
    <div id="locationCard" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-blue-800">
            Izinkan Lokasi Anda
        </h2>

        <p class="text-sm text-blue-700 mt-1">
            HabisIn memerlukan akses lokasi Anda untuk menampilkan toko terdekat dan membantu Anda menemukan makanan dengan lebih cepat.
        </p>

        <button
            onclick="requestLocation()"
            class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
        >
            Izinkan Lokasi
        </button>
    </div>
    @endif


    <h1 class="text-3xl font-bold text-gray-900 mb-6">
        🛍️ Daftar Toko
    </h1>

    {{-- Search + Filter Bar --}}
    <form method="GET" action="{{ route('buyer.shops') }}" class="flex gap-3 mb-6">
        <input
            name="search"
            value="{{ request('search') }}"
            type="text"
            placeholder="Cari toko..."
            class="w-full p-3 border rounded-lg"
        >

        <select id="filterSelect"
            class="p-3 border rounded-lg"
            onchange="filterShops()"
        >
            <option value="">Semua</option>
            <option value="nearby">Dekat (3 km)</option>
        </select>

        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
            Cari
        </button>
    </form>

    {{-- Shop List --}}
    <div id="shopList" class="space-y-4">
        @foreach($shops as $shop)
            <div class="shop-card flex gap-4 p-4 bg-white rounded-xl shadow"
                 data-name="{{ strtolower($shop->name) }}"
                 data-description="{{ strtolower($shop->description) }}"
            >
                <img
                    src="{{ $shop->logo ? Storage::url($shop->logo) : asset('images/no_image.jpg') }}"
                    class="w-20 h-20 rounded-lg object-cover"
                >

                <div class="flex-1">
                    <h2 class="text-lg font-semibold">{{ $shop->name }}</h2>
                    <p class="text-gray-600 text-sm">{{ $shop->description }}</p>
                    <p class="text-gray-500 text-sm mt-1">{{ $shop->address }}</p>


                    @if(!empty($shop->distance))
                    <p class="text-gray-600 text-sm">
                        <i class="fa-solid fa-location-dot mr-1"></i>
                        {{ number_format($shop->distance, 2) }} km
                    </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="mt-8">
        {{ $shops->links() }}
    </div>

</div>

<script>
function requestLocation() {
    if (!navigator.geolocation) {
        alert("Device Anda tidak mendukung lokasi.");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        pos => {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;

            // Reload halaman dengan param lat & lng
            const params = new URLSearchParams(window.location.search);
            params.set('lat', lat);
            params.set('lng', lng);
            window.location.search = params.toString();
        },
        err => {
            alert("Tidak dapat mengambil lokasi. Pastikan Anda mengizinkannya.");
        }
    );
}
</script>

</x-app-layout>
