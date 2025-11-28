<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">

        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            ✏️ Edit Produk: {{ $product->name }}
        </h1>

        <div class="bg-white rounded-lg shadow p-6">

            {{-- Form --}}
            <form action="{{ route('merchant.products.update', $product->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Produk --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nama Produk</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $product->name) }}"
                           class="w-full border-gray-300 rounded-md shadow-sm"
                           required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
                    <textarea name="description"
                              rows="3"
                              class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga & Stok --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Harga (Rp)</label>
                        <input type="number"
                               name="price"
                               value="{{ old('price', $product->price) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               min="0"
                               required>
                        @error('price')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Stok</label>
                        <input type="number"
                               name="stock"
                               value="{{ old('stock', $product->stock) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               min="0"
                               required>
                        @error('stock')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Current Image --}}
                @if ($product->image)
                    <div>
                        <p class="text-gray-700 font-medium mb-1">Gambar Saat Ini</p>
                        <img src="{{ Storage::url($product->image) }}"
                             class="w-40 rounded shadow mb-3">
                    </div>
                @endif

                {{-- Upload New Image --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Ganti Gambar (Opsional)</label>
                    <input type="file"
                           name="image"
                           accept="image/*"
                           class="w-full border-gray-300 rounded-md shadow-sm">

                    @error('image')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Preview --}}
                    <div id="preview" class="mt-4 hidden">
                        <p class="text-gray-700 mb-2">Preview Gambar Baru:</p>
                        <img id="preview-image" src="#" class="w-40 rounded shadow">
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end">
                    <a href="{{ route('merchant.dashboard') }}"
                       class="px-4 py-2 bg-gray-200 rounded-md mr-4">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Image Preview Script --}}
    <script>
        const input = document.querySelector('input[name="image"]');
        const preview = document.getElementById('preview');
        const previewImg = document.getElementById('preview-image');

        input.addEventListener('change', e => {
            const file = input.files[0];
            if (file) {
                preview.classList.remove('hidden');
                previewImg.src = URL.createObjectURL(file);
            }
        });
    </script>

</x-app-layout>
