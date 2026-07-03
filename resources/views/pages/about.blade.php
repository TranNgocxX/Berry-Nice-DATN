@extends('layouts.app')

@section('title', 'Giới thiệu - BerryNice Spa')

@section('content')
<section class="bg-[#FDFBF0] text-slate-800">
    <!-- Tiêu đề chính -->
    <div class="max-w-6xl mx-auto px-6 py-16 text-center">
        <h1 class="text-4xl font-bold mb-10 logo-font">Thiên Đường Trị Liệu</h1>
        <p class="text-sm text-slate-600 leading-relaxed">
            BerryNice tin rằng sự “vừa vặn” là chìa khóa của cân bằng – nơi cơ thể và tâm trí cùng hòa nhịp 
            trong trạng thái thư giãn tự nhiên. Mỗi lần ghé thăm là một hành trình nuôi dưỡng sức khỏe và 
            tinh thần, giúp bạn cảm nhận sự đổi thay tích cực từng ngày.
            Tại BerryNice Spa, chúng tôi kết hợp tinh hoa trị liệu cổ truyền Việt Nam với kỹ thuật hiện đại, 
            mang đến trải nghiệm phục hồi toàn diện, khơi nguồn vẻ đẹp và năng lượng sống mới.
        </p>
    </div>

    <!-- Ảnh -->
    <div class="w-full h-[420px] overflow-hidden">
        <img src="{{ asset('storage/banners/about-banner.jpeg') }}" alt="Không gian spa" class="w-full h-full object-cover">
    </div>

    <!-- Câu chuyện -->
    <div class="max-w-6xl mx-auto px-6 py-20 space-y-16">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div>
                <img src="{{ asset('storage/banners/about-story-1.jpeg') }}" alt="Phòng trị liệu" class="rounded-2xl shadow-lg">
            </div>
            <div>
                <h2 class="text-2xl text-[#498352] font-semibold mb-4 logo-font">Câu chuyện của chúng tôi</h2>
                <p class="text-slate-700 leading-relaxed">
                    Tại BerryNice Spa, triết lý của chúng tôi tập trung vào việc khôi phục vẻ đẹp tự nhiên của bạn. 
                    Chúng tôi mong muốn mang lại sự cân bằng cho cơ thể, tâm trí và tâm hồn bằng cách kết hợp 
                    các phương pháp trị liệu cổ truyền và hiện đại, phương Đông và phương Tây.
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div class="order-2 md:order-1">
                <h2 class="text-2xl text-[#498352] font-semibold mb-4 logo-font">Hành trình phát triển</h2>
                <p class="text-slate-700 leading-relaxed">
                    BerryNice Spa được thành lập với niềm đam mê mang lại sự thư giãn và chăm sóc sắc đẹp toàn diện. 
                    Chúng tôi luôn duy trì tiêu chuẩn dịch vụ cao cấp, kết hợp sản phẩm hữu cơ tự nhiên và kỹ thuật trị liệu chuyên sâu.
                </p>
            </div>
            <div class="order-1 md:order-2">
                <img src="{{ asset('storage/banners/about-story-2.jpeg') }}" alt="Không gian spa sang trọng" class="rounded-2xl shadow-lg">
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div>
                <img src="{{ asset('storage/banners/about-story-3.jpeg') }}" alt="Khu vực tiếp khách" class="rounded-2xl shadow-lg">
            </div>
            <div>
                <h2 class="text-2xl text-[#498352] font-semibold mb-4 logo-font">Cam kết chất lượng</h2>
                <p class="text-slate-700 leading-relaxed">
                    Chúng tôi tin rằng mỗi trải nghiệm tại BerryNice Spa đều là một hành trình thư giãn sâu sắc. 
                    Đội ngũ chuyên viên được đào tạo bài bản, tận tâm mang đến dịch vụ chu đáo và hiệu quả, 
                    giúp bạn tìm lại sự cân bằng và năng lượng tích cực.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
