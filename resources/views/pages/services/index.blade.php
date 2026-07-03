@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm')

@section('content')

<div class="max-w-7xl min-h-[70vh] mx-auto px-6 py-12">
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-slate-800">
            Kết quả tìm kiếm cho "{{ $keyword }}"
        </h1>
    </div>

    @if($services->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <x-service-card :service="$service" />
            @endforeach
        </div>

        @if($services->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $services->links('pagination::tailwind') }}
            </div>
        @endif
    @else
        <div class="text-center py-20">
            <h2 class="text-2xl font-bold text-slate-700">Không tìm thấy dịch vụ</h2>
            <p class="text-slate-500 mt-2">Không có kết quả cho "{{ $keyword }}"</p>
        </div>
    @endif
</div>

<style>
    .hero-bg { 
        background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=1920&q=80'); 
        background-size: cover; 
        background-position: center; 
    }
</style>

@endsection
