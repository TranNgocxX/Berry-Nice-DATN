@extends('layouts.app')

@section('title', 'Liên hệ - BerryNice Spa')

@section('content')
<section class="bg-[#FDFBF0] text-slate-800">
    <div class="max-w-6xl mx-auto px-6 py-16 text-center">
        <h1 class="text-4xl font-bold mb-10 logo-font">Liên hệ</h1>
        <p class="text-sm text-slate-600">Đừng ngần ngại liên hệ với BerryNice nhé, BerryNice luôn sẵn sàng hỗ trợ bạn!</p>
    </div>

    <!-- Banner -->
    <div class="w-full h-[400px] overflow-hidden">
        <img src="{{ asset('storage/banners/contact-banner.jpeg') }}" alt="Spa liên hệ" class="w-full h-full object-cover">
    </div>

    <!-- Thông tin liên hệ -->
    <div class="max-w-6xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-12">
        <div>
            <h2 class="text-2xl font-semibold mb-6 logo-font">BerryNice Spa</h2>
            <p>175 Tây Sơn, Đống Đa, Hà Nội</p>
            <p class="mt-2">M: <a href="tel:+84938789246" class="text-[#6B8F71] font-medium hover:underline">0900 000 000</a></p>
            <p class="text-sm text-slate-500">(WhatsApp/Zalo)</p>
            <p class="mt-2">E: <a href="mailto:contact@berrynice.vn" class="text-[#6B8F71] hover:underline">contact@berrynice.vn</a></p>

        </div>

        <div>
            <h2 class="text-2xl font-semibold mb-6 logo-font">Giờ hoạt động</h2>
            <p class="mb-4"><strong>BerryNice Spa:</strong> từ 9:00 đến 22:30, đặt lịch lần cuối lúc 21:00.</p>
        </div>
    </div>
</section>
@endsection
