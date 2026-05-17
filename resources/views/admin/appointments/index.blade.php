@extends('layouts.admin')

@section('title', 'Quản lý lịch hẹn')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Quản lý lịch hẹn</h1>
            <p class="text-slate-500 mt-1">Theo dõi và xử lý các lịch đặt Spa</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-3xl shadow-sm p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">Tên dịch vụ</label>
                <input type="text" name="keyword" value="{{ request('keyword') }}" 
                    placeholder="Nhập tên dịch vụ..."
                    class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">Trạng thái</label>
                <select name="status" class="w-full px-5 py-4 border border-slate-200 rounded-2xl">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">Ngày hẹn</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                       class="w-full px-5 py-4 border border-slate-200 rounded-2xl">
            </div>
            <div class="flex items-end">
                <button type="submit" 
                    class="p-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl transition-all duration-200 focus:ring-2 focus:ring-slate-300 flex items-center justify-center">    
                    <i class="fas fa-search text-lg"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Khách hàng</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Dịch vụ</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Thời gian</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Nhân viên</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Trạng thái</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase w-32">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($appointments as $appointment)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-5">
                        <div class="font-medium">{{ $appointment->appointmentDetail->customer_name }}</div>
                        <div class="text-sm text-slate-500">{{ $appointment->appointmentDetail->phone }}</div>
                    </td>
                    <td class="px-6 py-5 font-medium text-slate-800">{{ $appointment->service->name }}</td>
                    <td class="px-6 py-5 text-center text-sm">{{ $appointment->start_time }}</td>
                    <td class="px-6 py-5 text-center text-sm">
                        @if($appointment->employee)
                            {{ $appointment->employee->name }}
                        @else
                            <span class="text-amber-500 font-medium">Chưa phân</span>
                        @endif
                    </td>

                    <td class="px-6 py-5 text-center">
                        @php
                            $statusClass = match($appointment->status) {
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'confirmed' => 'bg-blue-100 text-blue-700',
                                'completed' => 'bg-emerald-100 text-emerald-700',
                                'rejected', 'cancelled' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-100 text-slate-600'
                            };
                        @endphp
                        <span class="inline-block px-4 py-1.5 rounded-2xl text-xs font-semibold {{ $statusClass }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <a href="{{ route('admin.appointments.show', $appointment) }}" 
                           class="inline-flex items-center justify-center w-9 h-9 bg-sky-100 hover:bg-sky-200 text-sky-600 rounded-2xl transition">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($appointments->hasPages())
            <div class="px-6 py-5 border-t">
                {{ $appointments->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection