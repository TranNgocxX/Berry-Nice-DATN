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

    <div class="bg-white rounded-3xl shadow-sm p-6 mb-8 border border-slate-100">
        <form method="GET" action="{{ route('admin.appointments.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            
            {{-- 1. Nhập tên dịch vụ --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Từ khóa dịch vụ</label>
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Nhập tên dịch vụ..."
                    class="w-full px-4 py-3 border border-slate-200 rounded-2xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition">
            </div>

            {{-- 2. Khách hàng --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Khách hàng</label>
                <input type="text" name="customer_name" value="{{ request('customer_name') }}" placeholder="Nhập tên khách hàng..."
                    class="w-full px-4 py-3 border border-slate-200 rounded-2xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition">
            </div>

            {{-- 3. Ngày hẹn --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Ngày hẹn</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-2xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition cursor-pointer">
            </div>

            {{-- 4. Chọn Nhân viên --}}
            <div class="relative">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nhân viên</label>
                <select name="employee_id" class="w-full pl-4 pr-10 py-3 border border-slate-200 rounded-2xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition cursor-pointer appearance-none bg-white">
                    <option value="">Tất cả nhân viên</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                    @endforeach
                </select>
                <span class="absolute right-4 top-[43px] pointer-events-none text-slate-400 text-xs"><i class="fas fa-chevron-down"></i></span>
            </div>

            {{-- 5. Chọn Dịch vụ --}}
            {{-- <div class="relative">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Gói dịch vụ</label>
                <select name="service_id" class="w-full pl-4 pr-10 py-3 border border-slate-200 rounded-2xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition cursor-pointer appearance-none bg-white">
                    <option value="">Tất cả dịch vụ</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                    @endforeach
                </select>
                <span class="absolute right-4 top-[43px] pointer-events-none text-slate-400 text-xs"><i class="fas fa-chevron-down"></i></span>
            </div> --}}

            {{-- 6. Chọn Trạng thái --}}
            <div class="relative">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Trạng thái</label>
                <select name="status" class="w-full pl-4 pr-10 py-3 border border-slate-200 rounded-2xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition cursor-pointer appearance-none bg-white">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
                <span class="absolute right-4 top-[43px] pointer-events-none text-slate-400 text-xs"><i class="fas fa-chevron-down"></i></span>
            </div>

            {{-- 7. Ô chọn Sắp xếp --}}
            <div class="relative">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Sắp xếp</label>
                <select name="sort" onchange="this.form.submit()"
                    class="w-full pl-4 pr-10 py-3 border border-slate-200 rounded-2xl text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition cursor-pointer appearance-none">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất trước</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất trước</option>
                </select>
                <span class="absolute right-4 top-[43px] pointer-events-none text-slate-400 text-xs"><i class="fas fa-chevron-down"></i></span>
            </div>

            {{-- 8. Ô chứa các Nút hành động tối giản liền mạch --}}
            <div class="flex items-center gap-2 h-[46px]">
                @if(request('keyword') || request('employee_id') || request('service_id') || request('customer_name') || request('status') || request('date') || request('sort'))
                    <a href="{{ route('admin.appointments.index') }}" 
                       class="flex-1 h-full bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-500 text-sm font-medium rounded-2xl transition flex items-center justify-center whitespace-nowrap">
                        Xóa lọc
                    </a>
                @endif
                
                <button type="submit" 
                    class="{{ (request('keyword') || request('employee_id') || request('service_id') || request('customer_name') || request('status') || request('date') || request('sort')) ? 'w-14' : 'w-full' }} h-full bg-slate-800 hover:bg-slate-900 text-white rounded-2xl transition shadow-sm flex items-center justify-center text-base"
                    title="Tìm kiếm kết quả">    
                    <i class="fas fa-search"></i>
                </button>
            </div>

        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Khách hàng</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Dịch vụ</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Giá tiền</th>
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
                        <div class="font-medium">#{{ $appointment->id }}</div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="font-medium">{{ $appointment->appointmentDetail->customer_name }}</div>
                        <div class="text-sm text-slate-500">{{ $appointment->appointmentDetail->phone }}</div>
                    </td>
                    <td class="px-6 py-5 font-medium text-slate-800">{{ $appointment->service->name }}</td>
                    <td class="px-6 py-5 text-center text-sm">{{ number_format($appointment->service->price, 0, ',', '.') }}đ</td>
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