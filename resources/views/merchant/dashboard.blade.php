<x-app-layout>
    <div class="max-w-6xl mx-auto py-10">

        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            👋 Selamat datang, {{ auth()->user()->name }}
        </h1>

        {{-- Shop Summary Card --}}
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800">
                Informasi Toko
            </h2>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-gray-500">Nama Toko</p>
                    <p class="font-bold text-lg">{{ $shop->name }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Saldo</p>
                    <p class="font-bold text-lg text-green-600">
                        Rp {{ number_format($shop->balance, 0, ',', '.') }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Alamat</p>
                    <p class="font-bold text-lg">{{ $shop->address }}</p>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-gray-500">Total Produk</p>
                <p class="text-3xl font-bold">{{ $totalProducts }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-gray-500">Total Penjualan</p>
                <p class="text-3xl font-bold">{{ $totalSales }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-gray-500">Total Pendapatan</p>
                <p class="text-3xl font-bold text-green-600">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- Product List --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">Produk Tersedia</h2>
                <a href="#"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                    + Tambah Produk
                </a>
            </div>

            @if ($shop->products->isEmpty())
                <p class="text-gray-500">Belum ada produk. Tambahkan produk pertamamu!</p>
            @else
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-2">Produk</th>
                            <th class="pb-2">Harga</th>
                            <th class="pb-2">Stock</th>
                            <th class="pb-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shop->products as $product)
                        <tr class="border-b">
                            <td class="py-3">{{ $product->name }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <a href="#"
                                   class="text-indigo-600">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</x-app-layout>
