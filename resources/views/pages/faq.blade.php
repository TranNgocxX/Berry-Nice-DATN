@extends('layouts.app')

@section('title', 'Q&A - BerryNice Spa')

@section('content')
<section class="bg-[#FDFBF0] text-slate-800">
    <!-- Tiêu đề -->
    <div class="max-w-6xl mx-auto px-6 py-16 text-center">
        <h1 class="text-4xl font-bold mb-10 logo-font">Q&A</h1>
        <p class="text-sm text-slate-600 leading-relaxed">
            Những thắc mắc thường gặp khi sử dụng dịch vụ tại BerryNice Spa. 
            Hy vọng phần Q&A dưới đây sẽ giúp bạn có trải nghiệm thoải mái và trọn vẹn hơn.
        </p>
    </div>

    <div class="w-full h-[420px] overflow-hidden">
        <img src="{{ asset('storage/banners/faq-banner.jpg') }}" alt="Hình ảnh spa" class="w-full h-full object-cover">
    </div>

    <!-- Accordion Q&A -->
    <div class="max-w-6xl mx-auto px-6 pb-20 mt-20" x-data="{ open: null }">
        <h2 class="text-2xl font-semibold mb-6 logo-font text-center">Các câu hỏi thường gặp</h2>
        <div class="divide-y divide-slate-200 border border-slate-100 rounded-2xl shadow-sm">

            <!-- 1. Quy tắc chung -->
            <div class="p-6">
                <button @click="open = (open === 1 ? null : 1)" 
                        class="w-full flex justify-between items-center text-left">
                    <span :class="open === 1 ? 'font-bold text-[#6B8F71]' : 'font-medium text-slate-700'">
                        Quy tắc chung
                    </span>
                    <i :class="open === 1 ? 'fas fa-chevron-up text-[#6B8F71]' : 'fas fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="open === 1" x-transition class="mt-4 text-slate-700 leading-relaxed">
                    Chúng tôi yêu quý trẻ em, nhưng để đảm bảo không gian yên tĩnh cho tất cả khách hàng, 
                    vui lòng trông nom bé cẩn thận và tránh làm ảnh hưởng đến hoạt động chung của spa.
                    <p>Chúng tôi cũng khuyến khích khách hàng sử dụng dịch vụ một cách có trách nhiệm, tuân thủ 
                    các hướng dẫn của nhân viên và giữ gìn vệ sinh chung.</p>
                    <p>Nếu có bất kỳ thắc mắc nào về dịch vụ hoặc cần hỗ trợ, đừng ngần ngại liên hệ với 
                    chúng tôi qua điện thoại hoặc email. Chúng tôi luôn sẵn sàng giúp đỡ bạn!</p>
                </div>
            </div>

            <!-- 2. Giờ hoạt động và ngày nghỉ -->
            <div class="p-6">
                <button @click="open = (open === 2 ? null : 2)" 
                        class="w-full flex justify-between items-center text-left">
                    <span :class="open === 2 ? 'font-bold text-[#6B8F71]' : 'font-medium text-slate-700'">
                        Giờ hoạt động và ngày nghỉ
                    </span>
                    <i :class="open === 2 ? 'fas fa-chevron-up text-[#6B8F71]' : 'fas fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="open === 2" x-transition class="mt-4 text-slate-700 leading-relaxed">
                    BerryNice Spa mở cửa từ 9:00 đến 22:30 mỗi ngày. Đặt lịch trước 21:00 để đảm bảo thời gian phục vụ tốt nhất.
                </div>
            </div>

            <!-- 3. Đặt hẹn -->
            <div class="p-6">
                <button @click="open = (open === 3 ? null : 3)" 
                        class="w-full flex justify-between items-center text-left">
                    <span :class="open === 3 ? 'font-bold text-[#6B8F71]' : 'font-medium text-slate-700'">
                        Đặt hẹn
                    </span>
                    <i :class="open === 3 ? 'fas fa-chevron-up text-[#6B8F71]' : 'fas fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="open === 3" x-transition class="mt-4 text-slate-700 leading-relaxed">
                    Quý khách nên đặt hẹn trước qua điện thoại hoặc trực tuyến để đảm bảo có thời gian phù hợp.
                </div>
            </div>

            <!-- 4. Giá, phí dịch vụ và phương thức thanh toán -->
            <div class="p-6">
                <button @click="open = (open === 4 ? null : 4)" 
                        class="w-full flex justify-between items-center text-left">
                    <span :class="open === 4 ? 'font-bold text-[#6B8F71]' : 'font-medium text-slate-700'">
                        Giá, phí dịch vụ và phương thức thanh toán
                    </span>
                    <i :class="open === 4 ? 'fas fa-chevron-up text-[#6B8F71]' : 'fas fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="open === 4" x-transition class="mt-4 text-slate-700 leading-relaxed">
                    BerryNice Spa công khai bảng giá dịch vụ. Quý khách có thể thanh toán bằng tiền mặt hoặc qua QR.
                    <p>Vui lòng chụp ảnh màn hình QR để thanh toán, hoặc sử dụng các ứng dụng ngân hàng hỗ trợ quét mã QR.</p>
                    <p>Sau khi chuyển khoản, hãy lưu lại ảnh xác nhận giao dịch. Khi đến spa, quý khách cần xuất trình ảnh này để nhân viên kiểm tra (nếu cần thiết).</p>
                </div>
            </div>

            <!-- 5. Độ tuổi, tình hình sức khỏe của khách -->
            <div class="p-6">
                <button @click="open = (open === 5 ? null : 5)" 
                        class="w-full flex justify-between items-center text-left">
                    <span :class="open === 5 ? 'font-bold text-[#6B8F71]' : 'font-medium text-slate-700'">
                        Độ tuổi, tình hình sức khỏe của khách
                    </span>
                    <i :class="open === 5 ? 'fas fa-chevron-up text-[#6B8F71]' : 'fas fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="open === 5" x-transition class="mt-4 text-slate-700 leading-relaxed">
                    Một số dịch vụ có thể không phù hợp với trẻ nhỏ hoặc khách có bệnh lý đặc biệt. 
                    Vui lòng thông báo tình trạng sức khỏe trước khi sử dụng dịch vụ.
                </div>
            </div>

            <!-- 6. Phụ nữ mang thai -->
            <div class="p-6">
                <button @click="open = (open === 6 ? null : 6)" 
                        class="w-full flex justify-between items-center text-left">
                    <span :class="open === 6 ? 'font-bold text-[#6B8F71]' : 'font-medium text-slate-700'">
                        Phụ nữ mang thai
                    </span>
                    <i :class="open === 6 ? 'fas fa-chevron-up text-[#6B8F71]' : 'fas fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="open === 6" x-transition class="mt-4 text-slate-700 leading-relaxed">
                    Một số liệu pháp massage hoặc xông hơi không khuyến khích cho phụ nữ mang thai. 
                    Vui lòng tham khảo ý kiến bác sĩ và thông báo cho nhân viên trước khi đặt dịch vụ.
                </div>
            </div>

            <!-- 7. Yêu cầu khi sử dụng dịch vụ -->
            <div class="p-6">
                <button @click="open = (open === 7 ? null : 7)" 
                        class="w-full flex justify-between items-center text-left">
                    <span :class="open === 7 ? 'font-bold text-[#6B8F71]' : 'font-medium text-slate-700'">
                        Yêu cầu khi sử dụng dịch vụ
                    </span>
                    <i :class="open === 7 ? 'fas fa-chevron-up text-[#6B8F71]' : 'fas fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="open === 7" x-transition class="mt-4 text-slate-700 leading-relaxed">
                    Quý khách vui lòng tuân thủ hướng dẫn của nhân viên, giữ gìn vệ sinh chung và tôn trọng không gian riêng tư của người khác.
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
