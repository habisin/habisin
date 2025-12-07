<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">

        {{-- Info Toko --}}
        <div class="bg-white rounded-lg shadow p-6 mb-8">

            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">

                {{-- Logo --}}
                <img class="w-32 h-32 object-cover rounded"
                    src="{{ $shop->logo ? Storage::url($shop->logo) : asset('images/no_image.jpg') }}">

                <div class="flex-1">
                    <h1 class="text-3xl font-bold">{{ $shop->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $shop->description }}</p>
                    <p class="mt-2 text-sm text-gray-700">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $shop->address }}
                    </p>

                    {{-- Tombol Peta --}}
                    <button onclick="document.getElementById('mapBox').classList.toggle('hidden')"
                        class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded-md flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot"></i>
                        Lihat Lokasi
                    </button>

                </div>

            </div>

            {{-- Peta --}}
            <div id="mapBox" class="hidden mt-4">
                <div id="map" class="h-64 rounded"></div>
            </div>

        </div>

        {{-- List produk --}}
        <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <i class="fa-solid fa-cart-shopping"></i>
            Produk Tersedia
        </h2>


        @if ($shop->products->isEmpty())
            <p class="text-gray-500">Produk belum tersedia.</p>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif


        <div class="grid grid-cols-1 gap-6">

            <form method="POST" action="{{ route('buyer.order.checkout') }}">
                @csrf

                <div class="space-y-4">

                    @foreach ($shop->products as $product)
                        <div class="bg-white rounded-lg shadow p-4 flex gap-4 items-start" x-data="{ qty: 0 }">

                            {{-- Foto Produk --}}
                            <img class="w-28 h-28 object-cover rounded"
                                src="{{ $product->image ? Storage::url($product->image) : asset('images/no_image.jpg') }}">

                            <div class="flex-1">

                                <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $product->description }}</p>

                                <p class="mt-2 font-bold text-indigo-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    <i class="fa-solid fa-box"></i>
                                    Stok: {{ $product->stock }}
                                </p>

                                {{-- Quantity --}}
                                <div class="flex items-center gap-3 mt-3">

                                    <button type="button" @click="qty > 0 && qty--"
                                        class="px-3 py-1 bg-gray-200 rounded">-</button>

                                    <span x-text="qty" class="min-w-[24px] text-center"></span>

                                    <button type="button" @click="qty < {{ $product->stock }} && qty++"
                                        class="px-3 py-1 bg-gray-200 rounded">+</button>

                                </div>

                                <input type="hidden" name="items[{{ $product->id }}]" :value="qty">

                            </div>
                        </div>
                    @endforeach

                </div>

                <button type="submit" class="mt-6 w-full bg-green-600 text-white py-3 rounded hover:bg-green-700">
                    <i class="fa-solid fa-credit-card"></i>
                    Checkout
                </button>

            </form>

        </div>

    </div>
</x-app-layout>

{{-- LEAFLET --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        let map = L.map('map').setView(
            [{{ $shop->latitude ?? 0 }}, {{ $shop->longitude ?? 0 }}],
            15
        );

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        L.marker([{{ $shop->latitude }}, {{ $shop->longitude }}])
            .addTo(map)
            .bindPopup("{{ $shop->name }}")
            .openPopup();
    });
</script>