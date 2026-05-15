@props(['service'])

<div class="service-card bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition group flex flex-col h-full">
    {{-- Ảnh --}}
    <div class="overflow-hidden h-64">
        @if($service->image)
            <img src="{{ asset('storage/'.$service->image) }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                 onerror="this.src='https://placehold.co/600x400?text=BerryNice+Spa'">
        @else
            <div class="w-full h-full bg-[#DDEAD1] flex items-center justify-center text-6xl">🌿</div>
        @endif
    </div>

    {{-- ND --}}
    <div class="p-6 flex-1 flex flex-col">
        <h5 class="text-xl font-semibold text-slate-800 mb-2 line-clamp-2 min-h-[3.5rem]">
            {{ $service->name }}
        </h5>
        
        <p class="text-slate-600 line-clamp-2 mb-4 flex-1">
            {{ $service->short_description }}
        </p>
        
        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
            <span class="text-2xl font-bold text-[#6B8F71]">
                {{ number_format($service->price) }}đ
            </span>
            <a href="{{ route('services.show', $service->id) }}" 
               class="px-5 py-2 rounded-2xl bg-[#8FAF8C] hover:bg-[#517D50] text-white text-sm transition">
                Xem chi tiết
            </a>
        </div>
    </div>
</div>