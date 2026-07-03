@extends('layouts.app')

@section('title', 'BerryNice Spa')

@section('content')

    {{-- Section 1: Hero --}}
    <section class="relative h-[50vh] flex flex-col justify-center text-white mb-32">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/20 z-10"></div>
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('/storage/banners/home-banner.jpeg');"></div>

        <!-- ND chính -->
        <div class="relative z-20 text-center px-6 max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold logo-font leading-[1.1] tracking-tight drop-shadow-2xl">
                Đến BerryNice,<br>
                <span class="text-[#EDE0C8]">tìm về nhịp nghỉ vừa vặn</span>
            </h1>
        </div>

        <!-- Thanh tìm kiếm -->
        <form action="{{ route('services.index') }}" method="GET"
            class="absolute bottom-0 translate-y-1/2 left-1/2 -translate-x-1/2 w-full max-w-3xl z-30 px-4">
            <div class="relative">

                <input type="text"
                    name="keyword"
                    placeholder="Tìm kiếm dịch vụ massage, chăm sóc da..."
                    class="w-full pl-14 pr-20 py-5 rounded-full bg-white/80 backdrop-blur-lg text-slate-700 text-base md:text-lg border border-transparent shadow-lg focus:outline-none focus:ring-2 focus:ring-[#4A6B53]/20 focus:border-[#4A6B53] transition-all duration-300">

                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-[#4A6B53]/70 text-xl"></i>
            </div>
        </form>

    </section>

    {{-- Section 2: Danh mục (các loại dịch vụ) --}}
    <section id="category-explorer" class="py-14 md:py-20 bg-[#FDFBF0]" 
            x-data="{ activeTab: {{ $categories->first()->id ?? 0 }} }">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-6 md:mb-10">
                <h2 class="text-4xl md:text-3xl font-bold logo-font text-[#498352] tracking-wide">
                    Dịch vụ của BerryNice
                </h2>
            </div>
            
            <div class="relative pt-10">
                <div class="flex flex-nowrap md:flex-wrap md:justify-center gap-6 md:gap-10 mb-10 overflow-x-auto pb-4 md:pb-0 no-scrollbar select-none">
                    @foreach($categories as $category)
                    <div @click="activeTab = {{ $category->id }}" 
                        class="flex flex-col items-center cursor-pointer group transition-all duration-300 min-w-[90px] md:min-w-0 md:w-32 shrink-0"
                        :class="activeTab == {{ $category->id }} ? 'opacity-100 scale-105' : 'opacity-50 hover:opacity-100'">

                        <!-- Logo danh mục -->
                        <div class="mb-2 flex items-center justify-center transition-transform group-hover:rotate-12">

                            @if($category->logo)
                                <img src="{{ asset('storage/' . $category->logo) }}" alt="{{ $category->name }}" class="w-12 h-12 object-contain">
                            @else
                                <div class="w-12 h-12 rounded-full bg-[#F4EFE5] flex items-center justify-center border border-[#E8DDCA]">
                                    <i class="fas fa-spa text-[#C4A47C] text-lg"></i>
                                </div>
                            @endif

                        </div>

                        <!-- Tên danh mục -->
                        <h3 class="text-center text-sm md:text-xs font-semibold uppercase tracking-tighter"
                            :class="activeTab == {{ $category->id }} ? 'text-[#C4A47C]' : 'text-slate-500'">
                            {{ $category->name }}
                        </h3>

                        <!-- Gạch chân khi active -->
                        <div class="h-0.5 bg-[#C4A47C] transition-all duration-300 mt-1.5" 
                            :class="activeTab == {{ $category->id }} ? 'w-full' : 'w-0'"></div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="max-w-2xl mx-auto text-center px-4">
                @foreach($categories as $category)
                <div x-show="activeTab == {{ $category->id }}" x-transition class="space-y-5">
                    <p class="text-slate-500 leading-relaxed text-sm md:text-base font-normal">
                        {{ $category->description }}
                    </p>
                    <a href="{{ route('services.category', $category) }}" 
                    class="inline-block bg-transparent hover:bg-[#9CC69B] text-[#4A6B53] hover:text-white
                    border border-[#4A6B53] hover:border-[#9CC69B] px-8 py-3.5 rounded-xl 
                    font-bold uppercase tracking-widest text-[11px] md:text-xs transition-all duration-300">
                        Xem thêm 
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 3: Dịch vụ --}}
    <section id="services" class="py-20 bg-[#FDFBF0]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl logo-font font-bold text-[#498352]">DỊCH VỤ MỚI NHẤT</h2>
                <p class="text-slate-600 mt-3">Khám phá các liệu trình chăm sóc tại Berry Nice</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($newServices as $service)
                    <x-service-card :service="$service" />
                @endforeach
            </div>

        </div>
    </section>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .hero-bg { background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(/storage/banners/home-banner.jpeg); background-position: center; background-repeat: no-repeat;}
    </style>
@endsection