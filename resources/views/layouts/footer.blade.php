<footer class="bg-[#517D50] text-[#FDFBF0]/80 font-light">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10">

            <!-- Cột 1: Logo & Mô tả -->
            <div class="sm:col-span-2 lg:col-span-1">
                <span class="text-2xl font-bold text-[#FDFBF0] tracking-tight block mb-4">BerryNice</span>
                <p class="text-sm leading-relaxed text-[#FDFBF0]/70">
                    Spa cao cấp mang đến sự thư giãn và chăm sóc sắc đẹp chuyên nghiệp.
                </p>
            </div>

            <!-- Cột 2: Các dịch vụ -->
            <div>
                <h4 class="text-[#FDFBF0] font-semibold mb-4 tracking-wide text-sm uppercase">Các dịch vụ</h4>
                <ul class="space-y-2 text-sm">
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('services.category', $category) }}" class="hover:text-white hover:underline decoration-[#8FAF8C] underline-offset-4 transition-all duration-300">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Cột 3: Liên kết nhanh -->
            <div>
                <h4 class="text-[#FDFBF0] font-semibold mb-4 tracking-wide text-sm uppercase">Liên kết nhanh</h4>
                <ul class="space-y-2 text-sm">
                    {{-- <li><a href="{{ route('home') }}" class="hover:text-white hover:underline decoration-[#8FAF8C] underline-offset-4 transition-all duration-300">Trang chủ</a></li> --}}
                    <li><a href ="{{ route('home') }}" class="hover:text-[#8FAF8C] transition">Trang chủ</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-[#8FAF8C] transition">Về chúng tôi</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-[#8FAF8C] transition">Q&A</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-[#8FAF8C] transition">Liên hệ</a></li>
                </ul>
            </div>

            <!-- Cột 4: Thông tin liên hệ -->
            <div>
                <h4 class="text-[#FDFBF0] font-semibold mb-4 tracking-wide text-sm uppercase">Liên hệ</h4>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 mt-0.5 text-[#8FAF8C] shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                        <span>175 Tây Sơn, Đống Đa, Hà Nội</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-[#8FAF8C] shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.47-5.114-3.76-6.584-2.824l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                        <span>0900 000 000</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-[#8FAF8C] shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                        <span>contact@berrynice.vn</span>
                    </li>
                </ul>
            </div>

            <!-- Cột 5: Giờ mở cửa -->
            <div>
                <h4 class="text-[#FDFBF0] font-semibold mb-4 tracking-wide text-sm uppercase">Giờ làm việc</h4>
                <ul class="space-y-2 text-sm">
                    <li class="text-[#FDFBF0]/60">Thứ 2 - Chủ Nhật</li>
                    <li class="font-semibold text-white text-base mt-1">8:00 - 21:00</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-[#FDFBF0]/10 py-6 text-center text-xs text-[#FDFBF0]/50">
        <p>© {{ date('Y') }} BerryNice Spa. All rights reserved.</p>
    </div>
</footer>