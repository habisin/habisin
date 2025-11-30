<x-app-layout>
    <div class="max-w-6xl mx-auto py-10">

        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            🧾 Daftar Pesanan - {{ $shop->name }}
        </h1>

        @if ($orders->isEmpty())
            <p class="text-gray-500">Belum ada pesanan masuk.</p>
        @endif

        <div class="space-y-4">
            @foreach ($orders as $order)
                <div 
                    x-data="{ open: false }"
                    class="bg-white shadow rounded-lg p-6 border hover:border-indigo-500 transition cursor-pointer"
                    @click="open = !open"
                >
                    {{-- Order Header --}}
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-lg">
                                Order #{{ $order->id }}
                            </p>

                            <p class="text-gray-500 text-sm">
                                {{ $order->created_at->format('d M Y, H:i') }}
                                - oleh <strong>{{ $order->user->name }}</strong>
                            </p>

                            <p class="mt-1 text-sm">
                                <span class="px-2 py-1 rounded text-white
                                    {{ $order->order_type === 'pickup' ? 'bg-blue-600' : 'bg-green-600' }}">
                                    {{ ucfirst($order->order_type) }}
                                </span>

                                @if(!$order->payment_status === 'paid')
                                    <span class="ml-2 px-2 py-1 text-xs rounded bg-yellow-500 text-white">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="flex flex-col items-end">
                            {{-- Status Dropdown --}}
                            <form method="POST" action="{{ route('merchant.orders.update', $order) }}">
                                @csrf
                                @method('PUT')

                                <select name="status"
                                    class="border rounded-md px-5 py-2 text-sm w-40"
                                    onchange="this.form.submit()"
                                    @click.stop
                                >
                                    <option value="pending"     {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing"  {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                                    <option value="completed"   {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled"   {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </form>

                            {{-- Tombol Hubungi Pembeli --}}
                            <a href="#"
                            @click.stop
                            class="inline-block mt-2 text-sm px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition w-40 text-center">
                                Hubungi Pembeli
                            </a>
                        </div>
                    </div>

                    {{-- Hidden Content --}}
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

                        {{-- Pickup or Delivery --}}
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

                            {{-- Ready Button --}}
                            @if ($order->status === 'confirmed')
                                <form method="POST" action="{{ route('merchant.orders.ready', $order) }}" class="mt-3">
                                    @csrf
                                    <button class="px-3 py-2 bg-green-600 text-white rounded-md">
                                        🚚 Pesanan Siap Dikirim
                                    </button>
                                </form>
                            @endif
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
