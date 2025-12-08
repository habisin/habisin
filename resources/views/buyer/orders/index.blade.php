<x-app-layout>
    <div class="max-w-6xl mx-auto py-10">

        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            🛒 Pesanan Saya
        </h1>

        @if ($orders->isEmpty())
            <p class="text-gray-500">Kamu belum memiliki pesanan.</p>
        @endif

        <div class="space-y-4">
            @foreach ($orders as $order)
                <div 
                    x-data="{ open: false }"
                    class="bg-white shadow rounded-lg p-6 border hover:border-indigo-500 transition cursor-pointer"
                    @click="open = !open"
                >
                    {{-- Header --}}
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-lg">
                                Order #{{ $order->id }}
                            </p>

                            <p class="text-gray-500 text-sm">
                                {{ $order->created_at->format('d M Y, H:i') }}
                                - <strong>{{ $order->shop->name }}</strong>
                            </p>

                            <p class="mt-1 text-sm flex items-center gap-2">

                                {{-- Pickup/Delivery Badge --}}
                                <span class="px-2 py-1 rounded text-white
                                    {{ $order->order_type === 'pickup' ? 'bg-blue-600' : 'bg-green-600' }}">
                                    {{ ucfirst($order->order_type) }}
                                </span>

                                {{-- Payment Status --}}
                                <span class="px-2 py-1 rounded text-white text-xs
                                    {{ $order->payment_status === 'paid' ? 'bg-green-600' : 'bg-yellow-500' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>

                                {{-- Order Status --}}
                                <span class="px-2 py-1 rounded text-white text-xs
                                    @switch($order->status)
                                        @case('pending') bg-gray-600 @break
                                        @case('processing') bg-blue-600 @break
                                        @case('completed') bg-green-600 @break
                                        @case('cancelled') bg-red-600 @break
                                    @endswitch
                                ">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>

                        {{-- Tombol untuk pembeli --}}
                        <div class="flex flex-col items-end">

                            {{-- Jika belum bayar, tampilkan tombol bayar --}}
                            @if ($order->payment_status !== 'paid')
                                <a 
                                    href="{{ route('buyer.orders.pay', $order) }}"
                                    @click.stop
                                    class="inline-block px-5 py-2 bg-yellow-500 text-white text-sm rounded-md hover:bg-yellow-600 transition w-44 text-center"
                                >
                                    💳 Lanjutkan Pembayaran
                                </a>
                            @endif

                            {{-- Hubungi Penjual --}}
                            <a 
                                href="https://wa.me/{{ $order->shop->phone ?? '' }}" 
                                target="_blank"
                                @click.stop
                                class="inline-block mt-2 text-sm px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition w-44 text-center"
                            >
                                Hubungi Penjual
                            </a>
                        </div>
                    </div>

                    {{-- Hidden Detail --}}
                    <div x-show="open" class="mt-6 border-t pt-4 text-sm">

                        {{-- Items --}}
                        <h3 class="font-semibold">Items:</h3>
                        <div class="mt-2 space-y-1">
                            @foreach ($order->items as $item)
                                <div class="flex justify-between text-gray-700">
                                    <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                    <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Total --}}
                        <p class="mt-4 font-bold">
                            Total: Rp {{ number_format($order->total_cost, 0, ',', '.') }}
                        </p>

                        {{-- Shipping / Pickup Info --}}
                        @if ($order->order_type === 'pickup')
                            <p class="mt-2">
                                Kode Pickup: 
                                <span class="font-bold text-indigo-600 text-lg">
                                    {{ $order->pickup_code }}
                                </span>
                            </p>
                        @else
                            <p class="mt-2">
                                Alamat Pengiriman: <strong>{{ $order->delivery_address }}</strong>
                            </p>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
