@extends('layouts.admin')

@section('title', 'Chi tiết lịch hẹn')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Chi tiết lịch hẹn</h1>
        <p class="text-slate-500">#{{ $appointment->id }} • {{ $appointment->start_time }}</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">KHÁCH HÀNG</p>
                <p class="text-xl font-semibold text-slate-800">{{ $appointment->appointmentDetail->customer_name }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">SỐ ĐIỆN THOẠI</p>
                <p class="text-xl font-semibold text-slate-800">{{ $appointment->appointmentDetail->phone }}</p>
            </div>
        </div>

        <div class="mt-8">
            <p class="text-sm font-semibold text-slate-500 mb-1">DỊCH VỤ</p>
            <p class="text-2xl font-bold text-slate-800">{{ $appointment->service->name }}</p>
        </div>

        <div class="grid grid-cols-2 gap-6 mt-8">
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">THỜI GIAN</p>
                <p class="text-lg font-medium">{{ $appointment->start_time }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">TRẠNG THÁI</p>
                @php
                    $statusClass = match($appointment->status) {
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'confirmed' => 'bg-blue-100 text-blue-700',
                        'completed' => 'bg-emerald-100 text-emerald-700',
                        'rejected', 'cancelled' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-700'
                    };
                @endphp
                <span class="inline-block px-4 py-2 rounded-2xl text-sm font-semibold {{ $statusClass }}">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
        </div>

        @if($appointment->appointmentDetail?->health_status)
        <div class="mt-8">
            <p class="text-sm font-semibold text-slate-500 mb-1">TÌNH TRẠNG SỨC KHỎE</p>
            <p class="bg-slate-50 p-4 rounded-2xl">{{ $appointment->appointmentDetail->health_status }}</p>
        </div>
        @endif

        @if($appointment->appointmentDetail->notes)
        <div class="mt-8">
            <p class="text-sm font-semibold text-slate-500 mb-1">GHI CHÚ</p>
            <p class="bg-slate-50 p-4 rounded-2xl">{{ $appointment->appointmentDetail->notes }}</p>
        </div>
        @endif

        <div class="mt-8 border-b pb-8">
            <p class="text-sm font-semibold text-slate-500 mb-1">NHÂN VIÊN ĐANG PHỤ TRÁCH</p>
            <p class="text-lg font-medium">
                @if($appointment->employee)
                    <span class="text-emerald-600">●</span> {{ $appointment->employee->name }}
                @else
                    <span class="text-slate-400 italic">Chưa phân công nhân viên</span>
                @endif
            </p>
        </div>

        <div class="mt-10">
            @if($appointment->status == 'pending')
                <form action="{{ route('admin.appointments.confirm', $appointment) }}" method="POST" class="mb-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Phân công nhân viên</label>
                        <select name="employee_id" required
                                class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-emerald-500 transition-all cursor-pointer">
                            <option value="">-- Chọn nhân viên để xác nhận lịch --</option>
                            @foreach($employees as $employee)
                                @if($employee->is_busy)
                                    <option value="{{ $employee->id }}" disabled class="text-red-400 bg-red-50">
                                        {{ $employee->name }} (Bận lịch khác)
                                    </option>
                                @else
                                    <option value="{{ $employee->id }}" class="text-slate-800">
                                        {{ $employee->name }} (Rảnh)
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        
                        @if($employees->where('is_busy', false)->isEmpty())
                            <p class="mt-3 text-sm text-red-500 bg-red-50 p-3 rounded-xl border border-red-100">
                                ⚠️ <strong>Thông báo:</strong> Không có nhân viên nào rảnh trong khung giờ này. Vui lòng thảo luận với khách hàng để đổi giờ hoặc từ chối lịch.
                            </p>
                        @endif
                    </div>

                    <button type="submit" 
                            @disabled($employees->where('is_busy', false)->isEmpty())
                            class="w-full bg-emerald-600 hover:bg-emerald-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white py-4 rounded-2xl font-semibold transition-all shadow-lg shadow-emerald-100">
                        Xác nhận
                    </button>
                </form>

                <form action="{{ route('admin.appointments.reject', $appointment) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            onclick="return confirm('Bạn có chắc muốn từ chối lịch hẹn này?')"
                            class="w-full bg-white border border-red-200 text-red-600 hover:bg-red-50 py-4 rounded-2xl font-semibold transition">
                        Từ chối lịch
                    </button>
                </form>
            @endif

            @if($appointment->status == 'confirmed')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <form action="{{ route('admin.appointments.complete', $appointment) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-semibold transition shadow-lg shadow-emerald-100">
                            Hoàn thành dịch vụ
                        </button>
                    </form>
                    <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Bạn có chắc muốn hủy lịch này?')"
                                class="w-full bg-white border border-amber-200 text-amber-600 hover:bg-amber-50 py-4 rounded-2xl font-semibold transition">
                            Hủy lịch hẹn
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-8 pb-10">
        <a href="{{ route('admin.appointments.index') }}" 
           class="text-slate-400 hover:text-slate-600 font-medium transition flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Quay lại
        </a>
    </div>
</div>
@endsection