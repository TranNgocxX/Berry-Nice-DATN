@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="min-h-screen bg-gray-50 py-6 px-4">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Header -->
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Dashboard thống kê</h1>
                <p class="text-gray-500">Tổng quan hoạt động Spa BerryNice</p>
            </div>
            <div class="text-sm text-gray-400 font-medium">
                Cập nhật: {{ now()->format('H:i - d/m/Y') }}
            </div>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @php
                $status = [
                    ['label' => 'Tổng lịch', 'value' => $total, 'color' => 'text-gray-800', 'bg' => 'bg-white'],
                    ['label' => 'Chờ duyệt', 'value' => $pending, 'color' => 'text-pink-600', 'bg' => 'bg-white'],
                    ['label' => 'Đã duyệt', 'value' => $confirmed, 'color' => 'text-emerald-600', 'bg' => 'bg-white'],
                    ['label' => 'Đã huỷ', 'value' => $cancelled, 'color' => 'text-red-600', 'bg' => 'bg-white'],
                ];
            @endphp

            @foreach($status as $sta)
            <div class="{{ $sta['bg'] }} rounded-2xl shadow-sm border border-gray-100 p-6 transition hover:shadow-md">
                <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">{{ $sta['label'] }}</div>
                <div class="text-4xl font-bold {{ $sta['color'] }} mt-2">{{ number_format($sta['value']) }}</div>
            </div>
            @endforeach
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
            <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-6 flex items-center">
                    <span class="w-1 h-5 bg-pink-500 rounded-full mr-2"></span>
                    Biểu đồ trạng thái lịch
                </h3>
                <div class="h-72">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-6 flex items-center">
                    <span class="w-1 h-5 bg-emerald-500 rounded-full mr-2"></span>
                    Tình trạng thanh toán
                </h3>
                <div class="h-72">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 flex flex-wrap items-center justify-between gap-4">
                <h3 class="font-bold text-xl text-gray-800">Lịch hẹn gần đây</h3>

                <div class="flex bg-gray-100/80 p-1 rounded-xl">
                    @foreach(['all' => 'Tất cả', 'pending' => 'Chờ', 'confirmed' => 'Đã duyệt', 'cancelled' => 'Đã huỷ'] as $key => $label)
                        <a href="{{ route('admin.dashboard', ['status' => $key]) }}"
                           class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ ($status ?? 'all') == $key ? 'bg-white shadow-sm text-pink-600' : 'text-gray-500 hover:text-gray-700' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Khách hàng</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Dịch vụ</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Thời gian</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Trạng thái</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Thanh toán</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($appointments as $a)
                            <tr class="hover:bg-pink-50/30 transition-colors group">
                                <td class="px-6 py-4 font-semibold text-gray-700">{{ $a->appointmentDetail->customer_name ?? 'Khách lẻ' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $a->service->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{-- {{ \Carbon\Carbon::parse($a->start_time)->format('H:i d/m') }} --}}
                                    {{ $a->start_time->format('H:i d/m') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="badge-status {{ $a->status }}">
                                        {{ $a->status == 'pending' ? 'Chờ duyệt' : ($a->status == 'confirmed' ? 'Đã duyệt' : 'Đã huỷ') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="px-3 py-1 rounded-lg text-xs font-bold {{ $a->payment_status == 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                        {{ $a->payment_status == 'paid' ? 'Đã thu' : 'Chờ' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Chưa có lịch hẹn nào...</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-50 flex items-center justify-between">
                <div class="text-xs font-medium text-gray-400 uppercase">
                    Trang {{ $appointments->currentPage() }} / {{ $appointments->lastPage() }}
                </div>
                <div class="flex gap-1">
                    {{ $appointments->links() }} 
                </div>
            </div>
        </div>

<div class="bg-white rounded-2xl shadow p-6">
    <h3 class="font-semibold text-xl mb-5 text-slate-800">Dịch vụ được yêu thích</h3>
    <div class="space-y-4">
        @foreach($topServices as $service)
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" 
                             alt="{{ $service->name }}" 
                             class="w-12 h-12 rounded-lg object-cover mr-3">
                    @endif
                    <span class="font-medium text-slate-700">{{ $service->name }}</span>
                </div>
                <div class="text-right">
                    <span class="block font-bold text-slate-800">{{ $service->appointments_count }}</span>
                    <span class="text-xs text-slate-400">lượt đặt</span>
                </div>
            </div>
        @endforeach
    </div>
</div>


    </div>
</div>

<script>
    const chartConfig = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } }
    };

    // Bar Chart
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Chờ duyệt', 'Đã duyệt', 'Đã huỷ'],
            datasets: [{
                data: [{{ $pending }}, {{ $confirmed }}, {{ $cancelled }}],
                backgroundColor: ['#ec4899', '#10b981', '#ef4444'],
                borderRadius: 8,
                barThickness: 40
            }]
        },
        options: chartConfig
    });

    // Pie Chart
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut', // Chuyển sang doughnut nhìn hiện đại hơn
        data: {
            labels: ['Đã thanh toán', 'Chưa thanh toán'],
            datasets: [{
                data: [{{ $paid }}, {{ $unpaid }}],
                backgroundColor: ['#10b981', '#f59e0b'],
                borderWidth: 0
            }]
        },
        options: { ...chartConfig, plugins: { legend: { display: true, position: 'bottom' } } }
    });
</script>

<style>
    .badge-status {
        @apply px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider;
    }
    .badge-status.pending { @apply bg-pink-100 text-pink-600; }
    .badge-status.confirmed { @apply bg-emerald-100 text-emerald-600; }
    .badge-status.cancelled { @apply bg-red-100 text-red-600; }
</style>
@endsection