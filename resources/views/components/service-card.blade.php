@props(['service'])

<a href="{{ route('services.show', $service->slug) }}"
   class="group flex flex-col h-full bg-[#FCFAF2] rounded-2xl overflow-hidden border border-[#EBE7D5] hover:border-[#C4B797] shadow-[0_4px_20px_-4px_rgba(107,143,113,0.08)] hover:shadow-[0_12px_30px_-6px_rgba(107,143,113,0.15)] transition-all duration-500 ease-out cursor-pointer">
    
    {{-- Khung ảnh (4:3) --}}
    <div class="relative w-full aspect-[4/3] overflow-hidden bg-[#EAE5D3]">
        @if($service->image)
            <img src="{{ asset('storage/'.$service->image) }}" 
                 class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-700 ease-out"
                 alt="{{ $service->name }}"
                 onerror="this.src='https://placehold.co/600x450?text=BerryNice+Spa'">
        @else
            <div class="w-full h-full flex items-center justify-center text-4xl bg-[#E2DAC3] text-[#6B8F71]/70">🌿</div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent pointer-events-none"></div>
    </div>

    {{-- Nội dung chi tiết --}}
    <div class="p-6 md:p-7 flex-1 flex flex-col justify-between">
        <div>
            {{-- Tiêu đề dịch vụ --}}
            <h5 class="text-lg md:text-xl font-medium text-[#2C3E35] tracking-wide mb-2 line-clamp-2 group-hover:text-[#6B8F71] transition-colors duration-300">
                {{ $service->name }}
            </h5>
            
            {{-- Mô tả ngắn --}}
            <p class="text-sm md:text-base text-[#606F66] font-light leading-relaxed mb-6 line-clamp-2">
                {{ $service->short_description }}
            </p>    
        </div>
        
        {{-- Thời gian & Giá tiền --}}
        <div class="flex items-center justify-between pt-4 border-t border-[#EBE7D5]">
            {{-- Thời gian - trái --}}
            <div class="flex items-center gap-1.5 text-xs md:text-sm text-[#2D531A] font-light tracking-wider uppercase">
                <svg class="w-4 h-4 text-[#8A9A90]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $service->duration }} phút</span>
            </div>
            
            {{-- Giá tiền - phải --}}
            <span class="text-lg md:text-xl font-semibold text-[#477023] tracking-tight">
                {{ number_format($service->price) }}<span class="text-sm font-normal ml-0.5">đ</span>
            </span>
        </div>
    </div>
</a>