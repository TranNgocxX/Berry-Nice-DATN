@extends('layouts.app')

@section('content')
{{-- Hero --}}
<section class="relative h-[50vh] flex items-center justify-center text-center text-white">
    <img src="{{ asset('storage/banners/banner.jpeg') }}" 
         alt="BerryNice Spa Hero" 
         class="absolute inset-0 w-full h-full object-cover">
    <div class="relative z-10 max-w-4xl px-6">
        <h1 class="text-4xl md:text-6xl font-bold logo-font mb-6">
            {{ $category->name }}
        </h1>
        <p class="text-lg md:text-xl leading-relaxed text-slate-100">
            Khám phá các dịch vụ thuộc danh mục này
        </p>
    </div>
    <div class="absolute inset-0 bg-black/30"></div> 
</section>

<div class="max-w-7xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($services as $service)
            <x-service-card :service="$service" />
        @endforeach
    </div>

    @if($services->hasPages())
        <div class="mt-16 flex justify-center">
            {{ $services->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
