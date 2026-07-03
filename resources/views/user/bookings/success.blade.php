@extends('layouts.app')

@section('content')

<main class="min-h-screen bg-[#FDFBF0] flex items-center justify-center px-4 py-10">

    <!-- Card -->
    <div class="w-full max-w-6xl px-6 md:px-14 py-10 md:py-14">

        <!-- Logo & tiêu đề -->
        <div class="text-center mb-10">

            <img src="/images/logo_BerryNice.png"
                 alt="Berry Nice Spa"
                 class="mx-auto w-72 md:w-[420px] h-auto mb-8 opacity-95 drop-shadow-sm">

            <h1 class="text-xl md:text-2xl font-semibold tracking-wide text-gray-800 mb-5">
                BẠN ĐÃ ĐẶT LỊCH THÀNH CÔNG DỊCH VỤ
            </h1>

            <p class="text-[#557A5E] text-xl md:text-3xl font-medium tracking-wide mb-3">
                {{ $booking->service->name }}
            </p>

            {{-- thời gian hẹn --}}
            <p class="text-sm md:text-base text-slate-500">
                ( {{ $booking->start_time->format('H:i d/m/Y') }} )
            </p>
        </div>

        <!-- Nội dung -->
        <section class="max-w-2xl mx-auto text-gray-700 leading-8 space-y-5 text-[15px] md:text-base">

            <p>
                Xin chào
                <span class="font-bold text-emerald-700">
                    {{ $booking->appointmentDetail->customer_name }}
                </span>,
            </p>

            <p>
                Cảm ơn bạn đã lựa chọn
                <span class="font-semibold text-emerald-700">
                    BerryNice Spa
                </span>.
            </p>

            <p>
                Chúng tôi đã ghi nhận yêu cầu và hiện đang ở trạng thái
                <strong>"Chờ xác nhận"</strong>.
                Đội ngũ tư vấn sẽ sớm liên hệ trực tiếp với bạn qua số điện thoại.
                Đừng quên kiểm tra điện thoại để không bỏ lỡ cuộc gọi từ chúng tôi nhé!
            </p>

            <p class="pt-2">
                Hẹn gặp lại bạn tại Spa!
            </p>

        </section>

    </div>

</main>

@endsection