@extends('layouts.app')

@section('content')
{{-- Hero --}}
    <section class="hero-bg h-[50vh] flex items-center bg-[#A8BCA1] text-white">
        <div class="max-w-4xl mx-auto text-center px-6">
            <h1 class="text-4xl md:text-6xl font-bold logo-font mb-4">{{ $category->name }}</h1>
            <p class="text-xl md:text-2xl mb-8">Khám phá các dịch vụ thuộc danh mục này</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-6 py-12">
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
    </div>
@endsection