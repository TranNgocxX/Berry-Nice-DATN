@extends('layouts.app')

@section('title', 'Chi tiết lịch hẹn')

@section('content')
<div class="max-w-lg mx-auto px-4 py-8">
    <!-- Nút quay lại -->
    <div class="mb-4">
        <a href="{{ route('bookings.index') }}" class="inline-flex items-center text-[#6B8F71] hover:text-[#557A5E] transition group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span class="font-medium">Quay lại</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
        @php
            $statusData = match($booking->status) {
                'pending' => ['class' => 'bg-amber-50 text-amber-600 border-amber-100', 'label' => 'Chờ xác nhận'],
                'confirmed' => ['class' => 'bg-blue-50 text-blue-600 border-blue-100', 'label' => 'Đã xác nhận'],
                'completed' => ['class' => 'bg-emerald-50 text-emerald-600 border-emerald-100', 'label' => 'Hoàn thành'],
                'cancelled' => ['class' => 'bg-red-50 text-red-600 border-red-100', 'label' => 'Đã hủy'],
                'rejected' => ['class' => 'bg-gray-50 text-gray-600 border-gray-100', 'label' => 'Bị từ chối'],
            };
        @endphp

        <!-- Header -->
        <div class="text-center px-6 pt-6 pb-4 border-b border-slate-100">
            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full border {{ $statusData['class'] }}">
                {{ $statusData['label'] }}
            </span>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">#{{ $booking->id }}</h2>
            <p class="text-sm text-slate-500">Đặt lúc {{ $booking->created_at->format('H:i, d/m/Y') }}</p>
        </div>

        <!-- Nội dung chính -->
        <div class="p-6 space-y-6">
            <!-- Dịch vụ & Thời gian -->
            <div class="flex flex-col sm:flex-row sm:justify-between gap-4 bg-slate-50 p-4 rounded-xl">
                <div>
                    <p class="text-xs text-slate-400 uppercase">Dịch vụ</p>
                    <p class="font-semibold text-slate-700">{{ $booking->service->name }}</p>
                </div>
                <div class="sm:text-right">
                    <p class="text-xs text-slate-400 uppercase">Thời gian hẹn</p>
                    <p class="font-semibold text-[#557A5E]">
                        {{ $booking->start_time->format('H:i d/m/Y') }}
                    </p>
                </div>
            </div>

            <!-- Thông tin khách & nhân viên -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-slate-400 uppercase">Khách hàng</p>
                    <p class="font-semibold text-slate-700">{{ $booking->appointmentDetail->customer_name ?? $booking->user->name ?? 'N/A' }}</p>
                    <p class="text-sm text-slate-500">{{ $booking->appointmentDetail->phone ?? 'Không có SĐT' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase">Chuyên viên</p>
                    <p class="font-semibold text-slate-700">{{ $booking->employee->name ?? 'Đang sắp xếp' }}</p>
                    <p class="text-sm text-slate-500">Nhân viên phụ trách</p>
                </div>
            </div>

            <!-- Thanh toán -->
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600">
                    {{ strtoupper($booking->payment_method ?? 'cash') }}
                </span>
                <span class="px-3 py-1 rounded-lg text-xs font-bold {{ $booking->payment_status == 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $booking->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                </span>
            </div>

            @if($booking->appointmentDetail?->health_status)
                <div>
                    <p class="text-xs text-slate-400 uppercase">Tình trạng sức khỏe</p>
                    <p class="text-slate-600 text-sm mt-1">{{ $booking->appointmentDetail->health_status }}</p>
                </div>
            @endif

            @if($booking->appointmentDetail?->notes)
                <div>
                    <p class="text-xs text-slate-400 uppercase">Ghi chú</p>
                    <p class="italic text-slate-500 text-sm mt-1">
                            "{{ $booking->appointmentDetail->notes }}"
                    </p>
                </div>
            @endif

            <!-- Tổng tiền -->
            <div class="flex justify-between items-center border-t pt-4">
                <span class="text-xs text-slate-400 uppercase">Tổng thanh toán</span>
                <span class="text-xl font-bold text-red-800">
                    {{ number_format($booking->price ?? 0) }}đ
                </span>
            </div>
        </div>

        <div class="px-6 pb-6">
            <button onclick="window.print()" class="w-full py-3 bg-[#6B8F71] text-white rounded-xl font-semibold hover:bg-[#557A5E] transition">
                In hóa đơn / Lưu ảnh
            </button>
        </div>
    </div>
</div>

<style>
    body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
    @media print {
        a, button { display: none !important; }
        body { background: white; }
    }
</style>
@endsection

