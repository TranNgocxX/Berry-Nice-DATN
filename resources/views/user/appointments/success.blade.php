@extends('layouts.app')

@section('content')
<main class="min-h-screen bg-[#FDFBF0] flex flex-col items-center justify-center py-12">

    <!-- Logo & tiêu đề -->
    <div class="text-center mb-8">
        <img src="/images/logo BerryNice.png" 
             alt="Berry Nice Spa" 
             class="mx-auto w-60 h-auto mb-4 opacity-90">
        <h1 class="text-xl sm:text-xl font-semibold tracking-wide mb-4">
            BẠN ĐÃ ĐẶT LỊCH THÀNH CÔNG DỊCH VỤ
        </h1>
        <p class="text-[#557A5E] text-lg md:text-2xl tracking-wide mb-2">
            {{ $appointment->service->name }}
        </p>
        {{-- ( thời gian hẹn ) --}}
        <p class="text-sm text-slate-500 mt-1">
            ( {{ $appointment->start_time->format('H:i d/m/Y') }} )
        </p>
    </div>

    <!-- Nội dung thông báo -->
    <section class="max-w-xl mx-auto text-left text-gray-700 leading-relaxed space-y-4">
        <p>Xin chào <span class="font-bold text-emerald-700">{{ $appointment->appointmentDetail->customer_name }}</span>,</p>
        <p>
            Cảm ơn bạn đã lựa chọn <span class="font-semibold text-emerald-700">BerryNice Spa</span>. 
        </p>
        <p> 
            Chúng tôi đã ghi nhận yêu cầu và đang ở trạng thái <strong>"Chờ xác nhận"</strong>. 
            Đội ngũ tư vấn sẽ sớm liên hệ trực tiếp với bạn qua số điện thoại. Đừng quên kiểm tra điện 
            thoại để không bỏ lỡ cuộc gọi từ chúng tôi nhé!
        </p>
        <p>Hẹn gặp lại bạn tại Spa!</p>
    </section>

    <!-- điều hướng -->
    <div class="flex flex-wrap justify-center gap-4 mt-10">
        <a href="{{ route('appointments.index') }}" 
           class="px-6 py-2 rounded-full border border-emerald-600 text-emerald-700 hover:bg-emerald-600 hover:text-white transition-all">
           <i class="fa fa-list-ul me-2"></i> Lịch hẹn của tôi
        </a>
        <a href="{{ route('home') }}" 
           class="px-6 py-2 rounded-full bg-emerald-600 text-white hover:bg-emerald-700 transition-all">
           <i class="fa fa-home me-2"></i> Trang chủ
        </a>
    </div>

</main>
@endsection

