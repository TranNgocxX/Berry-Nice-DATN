@extends('layouts.app')

@section('title', 'BerryNice Spa')

@section('content')

    {{-- Section 1: Hero --}}
    <section class="relative h-[85vh] flex flex-col justify-center text-white mb-32">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/20 z-10"></div>
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('/storage/hero/a.jpeg');"></div>

        <!-- ND chính -->
        <div class="relative z-20 text-center px-6 max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold logo-font leading-[1.1] tracking-tight drop-shadow-2xl">
                Đến BerryNice,<br>
                <span class="text-[#EDE0C8]">tìm về nhịp nghỉ vừa vặn</span>
            </h1>

            <a href="#category-explorer"
            class="inline-block mt-10 bg-[#C4A47C] hover:bg-[#B08E6A] text-white px-10 py-4 rounded-full text-lg font-semibold shadow-lg transition-transform hover:scale-105">
                Khám phá dịch vụ
            </a>
        </div>

        <!-- Thanh tìm kiếm -->
        <form action="{{ route('services.index') }}" method="GET"
            class="absolute bottom-[-2.5rem] left-1/2 -translate-x-1/2 w-full max-w-3xl z-30">
            <div class="relative">
                <input type="text"
                    name="keyword"
                    placeholder="Tìm kiếm dịch vụ massage, chăm sóc da..."
                    class="w-full pl-14 pr-36 py-5 rounded-full
                            bg-white/70 backdrop-blur-lg
                            text-slate-700 text-lg
                            border border-transparent
                            shadow-lg
                            focus:outline-none
                            focus:ring-2 focus:ring-[#C4A47C]/40
                            focus:border-[#C4A47C]
                            transition-all duration-300">

                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-[#C4A47C]/80 text-xl"></i>

                <button type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2
                            bg-[#C4A47C] hover:bg-[#B08E6A]
                            text-white font-semibold
                            px-6 py-3 rounded-full shadow-md transition-transform hover:scale-105">
                    Tìm kiếm
                </button>
            </div>
        </form>

    </section>

    {{-- Section 2: Danh mục (các loại dịch vụ) --}}
    <section id="category-explorer" class="pt-14 md:pt-28 py-10 md:py-14 bg-[#FDFBF0] border-b border-slate-100" 
            x-data="{ activeTab: {{ $categories->first()->id ?? 0 }} }">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-6 md:mb-10">
                <h2 class="text-2xl md:text-3xl font-bold logo-font text-slate-700 tracking-wide">Dịch vụ của BerryNice</h2>
            </div>
            
            <div class="relative">
                <div class="flex flex-nowrap md:flex-wrap md:justify-center gap-6 md:gap-10 mb-10 overflow-x-auto pb-4 md:pb-0 no-scrollbar select-none">
                    @foreach($categories as $category)
                    <div @click="activeTab = {{ $category->id }}" 
                        class="flex flex-col items-center cursor-pointer group transition-all duration-300 min-w-[90px] md:min-w-0 md:w-32 shrink-0"
                        :class="activeTab == {{ $category->id }} ? 'opacity-100 scale-105' : 'opacity-50 hover:opacity-100'">

                        <!-- Logo ảnh thay cho icon -->
                        <div class="w-30 h-30 mb-2 flex items-center justify-center transition-transform group-hover:rotate-12 background-size: cover">
                            <img src="{{ asset('storage/logos/' . $category->logo) }}" 
                                alt="{{ $category->name }}" 
                                class="w-12 h-12 object-contain" />

                        </div>

                        <!-- Tên danh mục -->
                        <h3 class="text-center text-[9px] md:text-xs font-semibold uppercase tracking-tighter"
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
                    <a href="{{ route('services.category', $category->id) }}" 
                    class="inline-block bg-[#A8BCA1] hover:bg-[#8FAF8C] text-white px-8 py-2.5 rounded-full font-bold uppercase tracking-widest text-[11px] md:text-xs">
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
                <h2 class="text-4xl font-bold text-slate-800">DỊCH VỤ MỚI NHẤT</h2>
                <p class="text-slate-600 mt-3">Khám phá các liệu trình chăm sóc tại Berry Nice</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredServices as $service)
                    <x-service-card :service="$service" />
                @endforeach
            </div>

        </div>
    </section>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .hero-bg { background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(/storage/hero/a.jpeg); background-size: cover; background-position: center; background-repeat: no-repeat;}
    </style>
@endsection