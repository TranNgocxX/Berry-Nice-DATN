@extends('layouts.app')

@section('title', 'Lịch của tôi')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 min-h-[70vh]">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-[#6B8F71]">Lịch sử đặt lịch</h1>
    </div>

    <!-- Lọc & Tìm kiếm -->
    <div class="mb-8">
        <form id="filterForm" action="{{ route('bookings.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            
            <!-- tìm kiếm -->
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="keyword" value="{{ request('keyword') }}" 
                    placeholder="Tìm dịch vụ" 
                    class="w-full pl-11 pr-4 py-2.5 bg-slate-100 rounded-2xl text-sm text-slate-600 
                            focus:ring-2 focus:ring-[#6B8F71] outline-none transition">
            </div>

            <!-- Lọc trạng thái -->
            <select name="status" onchange="this.form.submit()" 
                    class="md:w-44 bg-slate-100 rounded-2xl px-4 py-2.5 text-sm text-slate-600 
                        focus:ring-2 focus:ring-[#6B8F71] outline-none cursor-pointer">
                <option value="">Trạng thái</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Bị từ chối</option>
                <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Đã hủy</option>
            </select>

            <!-- Lọc ngày -->
            <div class="md:w-44 relative">
                <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()"
                    class="w-full bg-slate-100 rounded-2xl px-4 py-2.5 text-sm text-slate-600 
                            focus:ring-2 focus:ring-[#6B8F71] outline-none">
                
                @if(request()->anyFilled(['keyword','status','date']))
                    <a href="{{ route('bookings.index') }}" 
                    class="absolute -right-2 -top-2 w-6 h-6 bg-white border border-slate-200 rounded-full 
                            flex items-center justify-center text-slate-400 hover:text-[#6B8F71] transition" 
                    title="Xóa lọc">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Danh sách -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        {{-- Desktop --}}
        <div class="hidden md:block">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 font-semibold text-slate-600">Dịch vụ</th>
                        <th class="px-8 py-5 font-semibold text-slate-600">Thời gian</th>
                        <th class="px-8 py-5 text-center font-semibold text-slate-600">Trạng thái</th>
                        <th class="px-8 py-5 text-right font-semibold text-slate-600 w-32">Chi tiết</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($bookings as $booking)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="font-bold text-slate-800">{{ $booking->service->name }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-slate-700 font-medium">{{ $booking->start_time->format('d/m/Y') }}</div>
                            <div class="text-[#6B8F71] text-sm font-semibold">{{ $booking->start_time->format('H:i') }}</div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @php
                                $statusClass = match($booking->status) {
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'confirmed' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'cancelled', 'rejected' => 'bg-red-50 text-red-600 border-red-100',
                                    default => 'bg-slate-50 text-slate-600 border-slate-100'
                                };
                            @endphp
                            <span class="inline-flex px-4 py-1.5 rounded-full text-xs font-bold border {{ $statusClass }}">
                                {{ strtoupper($booking->status) }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('bookings.show', $booking->id) }}" 
                               class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-500 group-hover:bg-[#6B8F71] group-hover:text-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile --}}
        <div class="md:hidden divide-y divide-slate-100">
            @foreach($bookings as $booking)
            <a href="{{ route('bookings.show', $booking->id) }}" class="block p-5 active:bg-slate-50 transition-colors">
                <div class="flex justify-between items-start mb-3">
                    <div class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase border {{ $statusClass }}">
                        {{ $booking->status }}
                    </div>
                    <div class="text-xs text-slate-400">#{{ $booking->id }}</div>
                </div>
                <h4 class="font-bold text-slate-800 text-lg mb-1">{{ $booking->service->name }}</h4>
                <div class="flex items-center gap-4 text-sm text-slate-500">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $booking->start_time->format('d/m/Y') }}
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $booking->start_time->format('H:i') }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        @if($bookings->isEmpty())
            <div class="text-center py-20 px-6">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <p class="text-slate-500 font-medium">Bạn chưa có lịch hẹn nào.</p>
                <a href="{{ route('home') }}" class="text-pink-600 text-sm font-semibold mt-2 inline-block">Khám phá dịch vụ ngay →</a>
            </div>
        @endif
    </div>

    <div class="mt-8">
        {{ $bookings->links() }}
    </div>
</div>

<style>
    .pagination { @apply flex gap-2; }
    .page-item .page-link { @apply rounded-xl border-none bg-white shadow-sm text-slate-600 px-4 py-2; }
    .page-item.active .page-link { @apply bg-pink-600 text-white; }
</style>
@endsection
