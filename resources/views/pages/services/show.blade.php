@extends('layouts.app')

@section('title', $service->name)

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 md:py-12">
    
    {{-- Thanh điều hướng phụ (Breadcrumbs) --}}
    <nav class="flex items-center gap-2 text-xs md:text-sm text-[#8A9A90] font-light tracking-wide mb-6 md:mb-8" aria-label="Breadcrumb">
        <a href="/" class="hover:text-[#6B8F71] transition-colors duration-200">Trang chủ</a>
        <span class="text-[#C4B797]/60">/</span>
        <a href="{{ route('services.category', $service->category->slug) }}" class="hover:text-[#6B8F71] transition-colors duration-200">{{ $service->category->name }}</a>
        <span class="text-[#C4B797]/60">/</span>
        <span class="text-[#2C3E35] font-normal truncate max-w-[200px] md:max-w-none" aria-current="page">
            {{ $service->name }}
        </span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-14 items-start">

        {{-- Ảnh dịch vụ--}}
        <div class="w-full aspect-[4/3] lg:aspect-square rounded-2xl overflow-hidden border border-[#EBE7D5] shadow-[0_8px_30px_rgba(107,143,113,0.04)] lg:sticky lg:top-8 bg-[#EAE5D3]">
            @if($service->image)
                <img src="{{ asset('storage/'.$service->image) }}" 
                     alt="{{ $service->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-6xl bg-[#E2DAC3] text-[#6B8F71]/50">🌿</div>
            @endif
        </div>

        {{-- Thông tin chi tiết --}}
        <div class="flex flex-col h-full pt-1">
            {{-- Tiêu đề chính --}}
            <h1 class="text-3xl md:text-4xl font-medium text-[#2C3E35] tracking-wide leading-tight">
                {{ $service->name }}
            </h1>

            {{-- Thời lượng & Giá tiền  --}}
            <div class="mt-5 flex flex-wrap items-baseline gap-x-10 gap-y-2 py-2">
                {{-- Giá tiền (Được ưu tiên đứng trước và làm nổi bật theo hành vi mua hàng) --}}
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl md:text-3xl font-semibold text-[#537358] tracking-tight">
                        {{ number_format($service->price) }}
                    </span>
                    <span class="text-base text-[#537358] font-light">đ</span>
                </div>

                {{-- Thời lượng --}}
                <div class="flex items-center gap-1.5 text-sm md:text-base text-[#2D531A] font-light">
                    <svg class="w-4 h-4 text-[#8A9A90] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $service->duration }} phút</span>
                </div>
            </div>

            {{-- Mô tả ngắn --}}
            @if($service->short_description)
                <div class="mt-6">
                    <p class="text-base md:text-lg text-[#606F66] font-light leading-relaxed border-l-2 border-[#C4B797] pl-4 italic">
                        {{ $service->short_description }}
                    </p>
                </div>
            @endif

            {{-- Mô tả chi tiết --}}
            <div class="mt-8 border-t border-[#EBE7D5] pt-6" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="flex items-center justify-between w-full text-left focus:outline-none group">
                    <span class="text-lg font-medium text-[#2C3E35] group-hover:text-[#6B8F71] transition-colors duration-200">
                        Chi tiết liệu trình
                    </span>
                    <span class="text-slate-400 transition-transform duration-300"
                          :class="open ? 'rotate-180 text-emerald-600' : ''">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </button>

                <div x-show="open" x-transition class="mt-4">
                    <p class="text-base text-slate-700 leading-relaxed whitespace-pre-line">
                        {{ $service->long_description }}
                    </p>
                </div>
            </div>

            {{-- button Đặt lịch --}}
            <div class="mt-10">
                @auth
                    <a href="{{ route('bookings.create') }}?service_id={{ $service->id }}" 
                       class="inline-flex items-center justify-center gap-2.5 bg-[#9CC69B] hover:bg-[#3B5542] text-white px-8 py-3.5 rounded-xl text-base font-medium transition-all duration-300 shadow-[0_4px_14px_rgba(83,115,88,0.15)] hover:shadow-[0_6px_20px_rgba(83,115,88,0.25)] tracking-wide w-full sm:w-auto">
                        <i class="fas fa-calendar-plus"></i>
                        Đặt lịch
                    </a>
                @else
                    <button onclick="alert('Vui lòng đăng nhập để đặt lịch')"
                       class="inline-flex items-center justify-center gap-2.5 bg-[#A38A5E] hover:bg-[#76857C] text-white px-8 py-3.5 rounded-xl text-base font-medium transition-all duration-300">
                        <i class="fas fa-user"></i>
                        Đăng nhập để đặt lịch
                    </button>
                @endauth
            </div>

            {{-- Tiêu chuẩn chất lượng dạng tối giản --}}
            <div class="mt-12 pt-6 border-t text-xs md:text-sm text-slate-600 space-y-3 font-light">
                <p class="flex items-center gap-2">
                    <span class="fas fa-check text-emerald-500"></span> 
                    Kỹ thuật viên tận tâm.
                </p>
                <p class="flex items-center gap-2.5">
                    <span class="fas fa-check text-emerald-500"></span> 
                    Chăm sóc chuẩn mực.
                </p>
                <p class="flex items-center gap-2.5">
                    <span class="fas fa-check text-emerald-500"></span> 
                    Không gian thư giãn.
                </p>
                <p class="flex items-center gap-2.5">
                    <span class="fas fa-check text-emerald-500"></span> 
                    Liệu trình bài bản.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection