@extends('layouts.app')

@section('title', $service->name)

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

        <!-- Ảnh dịch vụ -->
        <div class="rounded-3xl overflow-hidden shadow-lg sticky top-6">
            @if($service->image)
                <img src="{{ asset('storage/'.$service->image) }}" 
                     alt="{{ $service->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="bg-slate-100 aspect-video flex items-center justify-center text-7xl text-slate-400">🌿</div>
            @endif
        </div>

        <!-- Thông tin dịch vụ -->
        <div>
            <!-- Tiêu đề -->
            <h1 class="text-4xl font-extrabold text-slate-800 tracking-tight">
                {{ $service->name }}
            </h1>

            <!-- Thời lượng & Giá -->
            <div class="mt-6 flex flex-wrap gap-8">
                <div>
                    <p class="text-sm text-slate-500">Thời lượng</p>
                    <p class="text-2xl font-semibold text-slate-700">{{ $service->duration }} phút</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Giá</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ number_format($service->price) }}đ</p>
                </div>
            </div>

            <!-- Mô tả ngắn -->
            @if($service->short_description)
            <div class="mt-8">
                <p class="text-lg font-medium text-slate-900 leading-relaxed">
                    {{ $service->short_description }}
                </p>
            </div>
            @endif

            <!-- Mô tả dài (Accordion) -->
            <div class="mt-8 border-t border-slate-200 pt-6" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="flex items-center justify-between w-full focus:outline-none">
                    <span class="text-xl font-semibold text-slate-800">Chi tiết dịch vụ</span>
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

            <!-- Nút đặt lịch -->
            <div class="mt-10">
                @auth
                    <a href="{{ route('appointment.create') }}?service_id={{ $service->id }}" 
                       class="inline-flex items-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl text-lg font-semibold transition shadow-md">
                        <i class="fas fa-calendar-plus"></i>
                        Đặt lịch ngay
                    </a>
                @else
                    <a onclick="alert('Vui lòng đăng nhập để đặt lịch')"
                       class="inline-flex items-center gap-3 bg-slate-600 hover:bg-slate-700 text-white px-8 py-4 rounded-2xl text-lg font-semibold transition">
                        <i class="fas fa-user"></i>
                        Đăng nhập để đặt lịch
                    </a>
                @endauth
            </div>

            <!-- Thông tin bổ sung -->
            <div class="mt-12 pt-8 border-t text-sm text-slate-600 space-y-3">
                <p class="flex items-center gap-2">
                    <i class="fas fa-check text-emerald-500"></i> Nhân viên chuyên nghiệp
                </p>
                <p class="flex items-center gap-2">
                    <i class="fas fa-check text-emerald-500"></i> Sản phẩm chăm sóc cao cấp
                </p>
                <p class="flex items-center gap-2">
                    <i class="fas fa-check text-emerald-500"></i> Không gian thư giãn riêng tư
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
