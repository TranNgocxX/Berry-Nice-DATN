<footer class="bg-[#517D50] text-slate-400">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            <!-- Cột 1: Logo & Mô tả -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-2xl font-bold text-white tracking-tight">BerryNice</span>
                </div>
                <p class="text-sm leading-relaxed">
                    Spa cao cấp mang đến sự thư giãn và chăm sóc sắc đẹp chuyên nghiệp.
                </p>
            </div>
            <!-- Cột 2: Các dịch vụ -->
            <div>
                <h4 class="text-white font-semibold mb-4">Các dịch vụ</h4>
                <ul class="space-y-2 text-sm">
                    @foreach($serviceCategories as $category)
                        <li>
                            <a href="{{ route('services.category', $category->id) }}" class="hover:text-white transition">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Cột 3: Thông tin -->
            <div>
                <h4 class="text-white font-semibold mb-4">Liên hệ</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <span>📍</span>
                        <span>175 Tây Sơn, Đống Đa, Hà Nội</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span>📞</span>
                        <span>0900 000 000</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span>✉️</span>
                        <span>contact@berrynice.vn</span>
                    </li>
                </ul>
            </div>

            <!-- Cột 4: Giờ mở cửa -->
            <div>
                <h4 class="text-white font-semibold mb-4">Giờ làm việc</h4>
                <ul class="space-y-2 text-sm">
                    <li>Thứ 2 - Chủ Nhật</li>
                    <li class="font-medium text-white">8:00 - 21:00</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-slate-800 py-6 text-center text-xs">
        <p>© {{ date('Y') }} BerryNice Spa. All rights reserved.</p>
    </div>
</footer>