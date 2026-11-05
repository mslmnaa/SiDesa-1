{{--
    Panel brand untuk halaman login & daftar (desktop).
    Parameter opsional: $headline (HTML), $subtitle
--}}
@php
    $statProducts = \App\Models\Product\Product::where('status', 'active')->count();
    $statVillages = \App\Models\Village::where('status', 'active')->count();
    $statCategories = \App\Models\Product\Category::count();
@endphp
<aside class="hidden lg:flex lg:w-[46%] xl:w-1/2 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden bg-gradient-to-br from-[#DEF9EC] via-[#BCE3C9] to-[#8FC79F]">
    <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-white/30"></div>
    <div class="absolute bottom-24 -right-16 w-72 h-72 rounded-full bg-white/20"></div>

    <div class="relative z-10 flex flex-col w-full p-10 xl:p-14">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 self-start">
            <span class="w-16 h-16 rounded-2xl bg-white shadow-[0_10px_25px_-12px_rgba(37,61,78,0.35)] ring-1 ring-black/5 flex items-center justify-center overflow-hidden">
                <img src="{{ asset('images/Logo.svg') }}" alt="" class="w-16 h-16 scale-[1.55]">
            </span>
            <span class="font-heading text-[30px] font-bold leading-none">BUMDes</span>
        </a>

        <div class="mt-16 xl:mt-20 max-w-md">
            <span class="inline-block px-3 py-1 rounded-full bg-white/70 text-[#2F9960] text-xs font-bold mb-5">Marketplace Produk Desa</span>
            <h1 class="font-heading text-[40px] xl:text-[46px] font-bold leading-[1.1]">
                {!! $headline ?? 'Belanja langsung<br>dari desa, untuk<br><span class="text-[#2F9960]">ekonomi desa.</span>' !!}
            </h1>
            <p class="mt-5 text-[15px] text-[#253D4E]/75 leading-relaxed max-w-sm">
                {{ $subtitle ?? 'Produk UMKM dan BUMDes pilihan, dikirim langsung dari pembuatnya.' }}
            </p>

            <dl class="mt-10 flex gap-8">
                @foreach([[$statProducts, 'Produk aktif'], [$statVillages, 'Desa mitra'], [$statCategories, 'Kategori']] as [$num, $label])
                    <div>
                        <dt class="sr-only">{{ $label }}</dt>
                        <dd class="font-heading text-3xl font-bold">{{ number_format($num, 0, ',', '.') }}</dd>
                        <p class="text-xs font-semibold text-[#253D4E]/60">{{ $label }}</p>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>

    <img src="{{ asset('images/newsletter-banner.png') }}" alt=""
         class="absolute bottom-0 right-0 w-[78%] max-w-[560px] object-contain object-bottom pointer-events-none select-none drop-shadow-xl"
         onerror="this.style.display='none'">
</aside>
