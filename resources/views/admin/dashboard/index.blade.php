@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
    // Bảng màu trạng thái
    $statusMap = [
        'pending'   => ['label' => 'Chờ duyệt',  'class' => 'bg-amber-50 text-amber-600 border-amber-200/60',   'dot' => 'bg-amber-400'],
        'confirmed' => ['label' => 'Đã duyệt',   'class' => 'bg-indigo-50 text-indigo-600 border-indigo-200/60', 'dot' => 'bg-indigo-500'],
        'completed' => ['label' => 'Hoàn thành', 'class' => 'bg-emerald-50 text-emerald-600 border-emerald-200/60', 'dot' => 'bg-emerald-500'],
        'cancelled' => ['label' => 'Đã huỷ',    'class' => 'bg-rose-50 text-rose-600 border-rose-200/60',    'dot' => 'bg-rose-500'],
        'rejected'  => ['label' => 'Bị từ chối', 'class' => 'bg-gray-50 text-gray-600 border-gray-200/60',   'dot' => 'bg-gray-400'],
    ];
@endphp

<div class="min-h-screen bg-[#f8fafc] py-8 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- 1. Header & Filter --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/60 pb-5">
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Dashboard</h1>
                <p class="text-slate-500 text-sm mt-0.5">Tổng quan hiệu suất vận hành Spa BerryNice</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs text-slate-400 font-medium hidden lg:inline italic">Cập nhật: {{ now()->format('H:i - d/m/Y') }}</span>
                <div class="inline-flex rounded-xl bg-slate-200/60 p-1 text-xs font-bold shadow-inner">
                    @foreach(['week' => '7 ngày', 'month' => '30 ngày', 'quarter' => '90 ngày'] as $key => $label)
                        <a href="{{ request()->fullUrlWithQuery(['period' => $key]) }}" 
                           class="px-4 py-2 rounded-lg transition-all duration-200 {{ $currentPeriod == $key ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 2. Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach([
                'total'     => ['Tổng lịch hẹn', 'text-slate-800', 'bg-slate-500'],
                'pending'   => ['Lịch chờ duyệt', 'text-amber-600', 'bg-amber-500'],
                'confirmed' => ['Lịch đã duyệt', 'text-indigo-600', 'bg-indigo-500'],
                'completed' => ['Đã hoàn thành', 'text-emerald-600', 'bg-emerald-500'],
                'cancelled' => ['Lịch đã huỷ', 'text-rose-600', 'bg-rose-500'],
            ] as $key => $meta)
                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 h-1 w-full {{ $meta[2] }} opacity-70"></div>
                    <div class="text-slate-400 text-[10px] font-black uppercase tracking-wider">{{ $meta[0] }}</div>
                    <div class="text-2xl font-black {{ $meta[1] }} mt-2 tracking-tight group-hover:scale-105 transition-transform origin-left">
                        {{ number_format($summary[$key] ?? 0) }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Biểu đồ --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-6 flex items-center">
                    <span class="w-1.5 h-4 bg-indigo-500 rounded-full mr-2.5"></span>Trạng thái lịch hẹn
                </h3>
                <div class="h-80 w-full"><canvas id="statusChart"></canvas></div>
            </div>

            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-6 flex items-center">
                    <span class="w-1.5 h-4 bg-emerald-500 rounded-full mr-2.5"></span>Doanh thu ước tính (VNĐ)
                </h3>
                <div class="h-80 w-full"><canvas id="revenueChart"></canvas></div>
            </div>
        </div>

        {{-- Timeline chọn ngày --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider flex items-center">
                    <span class="w-1.5 h-4 bg-sky-500 rounded-full mr-2.5"></span>
                    Dòng thời gian: <span class="ml-2 text-sky-600 lowercase font-normal">{{ \Carbon\Carbon::parse(request('date', now()))->format('d/m/Y') }}</span>
                </h3>
                
                <div class="relative min-w-[200px]">
                    <input type="date" id="timelineDatePicker" value="{{ request('date', now()->format('Y-m-d')) }}"
                           class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-sky-500 transition-all outline-none">
                    <div class="absolute left-3 top-2.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto py-4 flex gap-4 scrollbar-thin">
                @forelse($timelineData as $slot)
                    <div class="inline-block min-w-[180px] bg-slate-50/50 border border-slate-100 rounded-2xl p-4 align-top flex-shrink-0">
                        <div class="text-[11px] font-bold text-slate-400 border-b border-slate-200/60 pb-2 mb-3 flex justify-between items-center">
                            <span>{{ $slot['time'] }}</span>
                            @if(count($slot['appointments']) > 0)
                                <span class="flex h-2 w-2 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-pink-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-pink-500"></span>
                                </span>
                            @endif
                        </div>

                        <div class="space-y-3 max-h-[300px] overflow-y-auto scrollbar-none">
                            @forelse($slot['appointments'] as $app)
                                @php $style = $statusMap[$app->status] ?? $statusMap['pending']; @endphp
                                <div class="p-3 rounded-xl text-xs border bg-white shadow-sm hover:shadow-md transition-all duration-200 {{ $style['class'] }}">
                                    <div class="font-black truncate text-slate-800">{{ $app->user->name ?? 'Khách lẻ' }}</div>
                                    <div class="text-[10px] text-slate-500 truncate mt-1 font-medium italic">{{ $app->service->name ?? 'N/A' }}</div>
                                    <div class="mt-3 flex items-center justify-between text-[9px] font-black border-t border-slate-100 pt-2">
                                        <span class="text-slate-400">⏱ {{ \Carbon\Carbon::parse($app->start_time)->format('H:i') }}</span>
                                        <span class="uppercase tracking-widest">{{ $style['label'] }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-[10px] text-slate-300 italic text-center py-10">Trống lịch</div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center py-10 text-slate-400 italic font-medium">Không tìm thấy khung giờ hoạt động.</div>
                @endforelse
            </div>
        </div>

        {{-- Top dịch vụ --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-5 flex items-center">
                <span class="w-1.5 h-4 bg-amber-500 rounded-full mr-2.5"></span>Dịch vụ phổ biến nhất
            </h3>
            <div class="divide-y divide-slate-100 overflow-y-auto pr-1 flex-1 scrollbar-thin">
                @foreach($topServices as $service)
                    <div class="flex items-center justify-between py-3.5 first:pt-0 last:pb-0 group">
                        <span class="text-sm font-semibold text-slate-600 group-hover:text-slate-900 transition-colors truncate mr-3">{{ $service->name }}</span>
                        <span class="text-xs font-black px-3 py-1 bg-pink-50 text-pink-600 border border-pink-100 rounded-full flex-shrink-0">
                            {{ $service->appointments_count }} lượt
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Bảng danh sách lịch hẹn gần đây --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-base text-slate-800">Lịch hẹn gần đây</h3>
                </div>
                <a href="{{ route('admin.appointments.index') }}" class="px-4 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 rounded-xl text-xs font-bold text-slate-700 transition-all shadow-sm flex items-center gap-1.5 w-fit">
                    Xem toàn bộ 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100">
                            @foreach(['Khách hàng', 'Thông tin dịch vụ', 'Thời gian hẹn', 'Trạng thái'] as $th)
                                <th class="px-6 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $th }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentAppointments as $a)
                            @php $style = $statusMap[$a->status] ?? $statusMap['pending']; @endphp
                            <tr class="hover:bg-slate-50/40 transition-colors group">
                                <td class="px-6 py-4 font-bold text-slate-700 text-sm">{{ $a->user->name ?? 'Khách lẻ' }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-700 text-sm">{{ $a->service->name ?? '-' }}</div>
                                    <div class="text-[11px] font-medium text-slate-400 mt-0.5">{{ number_format($a->service->price ?? 0) }}đ</div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-500">
                                    {{ ($a->start_time)->format('H:i • d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $style['class'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $style['dot'] }}"></span>
                                        {{ $style['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-400 italic">Hệ thống chưa ghi nhận dữ liệu lịch đặt nào...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    // Xử lý bộ lọc ngày cho Timeline
    document.getElementById('timelineDatePicker').addEventListener('change', function() {
        const url = new URL(window.location.href);
        url.searchParams.set('date', this.value);
        window.location.href = url.toString();
    });

    Chart.defaults.color = '#94a3b8';
    Chart.defaults.font.family = 'Inter, system-ui, sans-serif';

    // Biểu đồ trạng thái
    const statusData = @json($chartData);
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: statusData.map(i => i.label),
            datasets: [
                { label: 'Thành công', data: statusData.map(i => i.success), backgroundColor: '#10b981', borderRadius: 6 },
                { label: 'Chờ/Duyệt', data: statusData.map(i => i.pending), backgroundColor: '#f59e0b', borderRadius: 6 },
                { label: 'Đã hủy', data: statusData.map(i => i.cancelled), backgroundColor: '#f43f5e', borderRadius: 6 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } },
            scales: {
                x: { stacked: true, grid: { display: false } },
                y: { stacked: true, grid: { color: '#f1f5f9' }, border: { display: false } }
            }
        }
    });

    // Biểu đồ doanh thu
    const revenueData = @json($revenueData);
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: revenueData.map(i => i.label),
            datasets: [
                { label: 'Thực tế', data: revenueData.map(i => i.actual), borderColor: '#10b981', tension: 0.4, fill: true, backgroundColor: '#10b98108' },
                { label: 'Mục tiêu', data: revenueData.map(i => i.expected), borderColor: '#6366f1', borderDash: [5, 5], tension: 0.4 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' } },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { color: '#f1f5f9' }, ticks: { callback: v => v.toLocaleString() + 'đ' } }
            }
        }
    });
</script>

<style>
    .scrollbar-thin::-webkit-scrollbar { height: 6px; width: 6px; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    .scrollbar-none::-webkit-scrollbar { display: none; }
</style>
@endsection