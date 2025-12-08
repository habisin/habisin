<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>HabisIn - Solusi Cerdas Anti Food Waste</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Font Awesome via Cloudflare --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
          integrity="Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite('resources/css/app.css')
</head>

<body class="bg-teal-50 text-gray-800 scroll-smooth">

{{-- ================= NAVBAR ================= --}}
<nav class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur border-b border-white/30">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">

        <a href="/" class="flex items-center gap-2 text-teal-600 font-bold text-xl">
            <i class="fa-solid fa-utensils"></i> HabisIn
        </a>

        <div class="hidden md:flex items-center gap-8 font-medium">
            <a href="#benefit-seller" class="hover:text-teal-600">Untuk Toko</a>
            <a href="#benefit-buyer" class="hover:text-teal-600">Untuk Pembeli</a>
            <a href="#sdgs" class="hover:text-teal-600">SDGs</a>
            <a href="/login" class="hover:text-teal-600">Masuk</a>
            <a href="/register"
               class="border-2 border-teal-500 text-teal-500 px-4 py-2 rounded-lg hover:bg-teal-500 hover:text-white transition">
                Daftar
            </a>
        </div>

        <button id="menuBtn" class="md:hidden text-2xl">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
        <a href="#benefit-seller" class="block px-6 py-3 hover:bg-gray-100">Untuk Toko</a>
        <a href="#benefit-buyer" class="block px-6 py-3 hover:bg-gray-100">Untuk Pembeli</a>
        <a href="#sdgs" class="block px-6 py-3 hover:bg-gray-100">SDGs</a>
        <a href="/login" class="block px-6 py-3 hover:bg-gray-100">Masuk</a>
        <a href="/register"
           class="block px-6 py-3 bg-teal-600 text-white hover:bg-teal-700">
            Daftar
        </a>
    </div>
</nav>


{{-- ================= HERO ================= --}}
<section class="relative min-h-[85vh] bg-center bg-cover flex items-center justify-center"
        style="background-image: url('{{ asset('images/pancakes-2291908_1920.jpg') }}')">
    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10 text-center px-6 max-w-2xl">
        <h1 class="text-white text-4xl md:text-6xl font-extrabold leading-tight drop-shadow-lg">
            Makanan sisa bukan berarti sampah.
        </h1>
        <p class="text-gray-200 mt-4 text-lg">
            Lawan pemborosan makanan mulai dari sekarang.
        </p>

        <div class="mt-8 flex justify-center gap-4">
            <a href="#"
               class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-8 py-4 rounded-full shadow-xl transition">
                Mulai Sekarang
            </a>
        </div>
    </div>
</section>


{{-- ================= SELLER ================= --}}
<section id="benefit-seller" class="py-20 bg-gradient-to-b from-white to-teal-50">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Manfaat untuk Toko / UMKM</h2>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach([
                ['💰','Pendapatan Tambahan','Makanan sisa jadi uang'],
                ['♻️','Kurangi Limbah','Lebih ramah lingkungan'],
                ['📱','Mudah Digunakan','Upload produk cepat']
            ] as $item)
                <div class="bg-white/80 backdrop-blur p-6 rounded-2xl shadow-md hover:shadow-xl transition hover:-translate-y-1">
                    <div class="text-4xl mb-3">{{ $item[0] }}</div>
                    <h3 class="font-semibold text-xl">{{ $item[1] }}</h3>
                    <p class="text-gray-600 mt-2">{{ $item[2] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ================= BUYER ================= --}}
<section id="benefit-buyer" class="py-20 bg-teal-100">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Manfaat untuk Pembeli</h2>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach([
                ['🥐','Harga Murah','Lebih hemat'],
                ['😋','Masih Enak','Layak konsumsi'],
                ['🌍','Ramah Lingkungan','Ikut selamatkan bumi']
            ] as $item)
                <div class="bg-white/80 backdrop-blur p-6 rounded-2xl shadow-md hover:shadow-xl transition hover:-translate-y-1">
                    <div class="text-4xl mb-3">{{ $item[0] }}</div>
                    <h3 class="font-semibold text-xl">{{ $item[1] }}</h3>
                    <p class="text-gray-600 mt-2">{{ $item[2] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ================= SDGS ================= --}}
<section id="sdgs" class="py-20 bg-gradient-to-b from-teal-50 to-green-100">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

        <div>
            <h2 class="text-3xl font-bold mb-4">Kontribusi terhadap SDGs 🌱</h2>
            <p class="text-gray-700 mb-6">
                HabisIn membantu dunia menjadi lebih adil dan berkelanjutan.
            </p>

            <ul class="space-y-4">
                <li class="flex items-center gap-3">
                    <span class="text-2xl">🍚</span>
                    <div>
                        <strong>Zero Hunger</strong>
                        <p class="text-sm text-gray-600">Makanan tidak terbuang</p>
                    </div>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-2xl">♻️</span>
                    <div>
                        <strong>Responsible Consumption</strong>
                        <p class="text-sm text-gray-600">Lebih bijak konsumsi</p>
                    </div>
                </li>
            </ul>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <img src="{{ asset('images/sdgs/2.svg') }}" class="rounded-xl shadow">
            <img src="{{ asset('images/sdgs/12.svg') }}" class="rounded-xl shadow">
        </div>
    </div>
</section>


{{-- ================= CTA ================= --}}
<section class="bg-gradient-to-r from-teal-700 to-teal-500 py-20 text-white text-center">
    <h2 class="text-3xl font-bold">Yuk pakai HabisIn sekarang!</h2>
    <p class="mt-2">Satu langkah kecil, dampak besar.</p>
    <div class="mt-6">
        <a href="/register"
           class="bg-white text-teal-700 px-8 py-3 rounded-xl shadow hover:bg-teal-50 font-semibold transition">
            Daftar Gratis
        </a>
    </div>
</section>


{{-- ================= FOOTER ================= --}}
<footer class="bg-gray-900 text-gray-400 text-center py-6">
    <p>© {{ date('Y') }} HabisIn - Solusi cerdas anti food waste.</p>
</footer>


{{-- ================= SCRIPT MOBILE MENU ================= --}}
<script>
document.getElementById('menuBtn').addEventListener('click', () => {
    document.getElementById('mobileMenu').classList.toggle('hidden')
})
</script>

</body>
</html>
