<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    // Lấy toàn bộ dữ liệu cần thiết cho trang Dashboard.
    public function getDashboardData(string $chartPeriod = 'week', ?string $date = null): array
    {
        $config = config('spa.working_hours');
        // Đảm bảo luôn có ngày hợp lệ
        $targetDate = $date ?: now()->format('Y-m-d');

        return [
            'summary'            => $this->getSummary(),
            'recentAppointments' => $this->getRecentAppointments(),
            'topServices'        => $this->getTopServices(),
            'chartData'          => $this->getAppointmentChart($chartPeriod),
            'revenueData'        => $this->getRevenueChart($chartPeriod),
            'timelineData'       => $this->getTimelineDataByDay($targetDate, $config), // Làm phẳng mảng
            'currentPeriod'      => $chartPeriod,
            'currentDate'        => $targetDate,
        ];
    }

    // Thống kê tổng hợp số lượng lịch hẹn theo trạng thái.
    private function getSummary(): array
    {
        $stats = Appointment::query()
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
            ")
            ->first();

        return [
            'total'     => (int) ($stats->total ?? 0),
            'pending'   => (int) ($stats->pending ?? 0),
            'confirmed' => (int) ($stats->confirmed ?? 0),
            'completed' => (int) ($stats->completed ?? 0),
            'cancelled' => (int) ($stats->cancelled ?? 0),
        ];
    }

    // Lấy lịch hẹn mới nhất
    private function getRecentAppointments()
    {
        return Appointment::query()
            ->with(['user:id,name', 'service:id,name,price'])
            ->latest()
            ->take(5)
            ->get();
    }

    // Lấy dịch vụ phổ biến
    private function getTopServices()
    {
        return Service::withCount(['appointments' => function ($q) {
            $q->whereIn('status', ['confirmed', 'completed']);
        }])
            ->orderByDesc('appointments_count')
            ->take(5)
            ->get();
    }

    // Hàm tiện ích để chuyển đổi chuỗi khoảng thời gian thành số ngày
    private function getDaysByPeriod(string $period): int
    {
        return match ($period) {
            'week'    => 7,
            'month'   => 30,
            'quarter' => 90,
            default   => 7,
        };
    }

    private function getAppointmentChart(string $period): array
    {
        $days = $this->getDaysByPeriod($period);
        $startDate = now()->subDays($days - 1)->startOfDay();

        $rawData = Appointment::query()
            ->selectRaw("
            DATE(start_time) as date,
            SUM(CASE WHEN status IN ('confirmed', 'completed') THEN 1 ELSE 0 END) as success,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
        ")
            ->where('start_time', '>=', $startDate)
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        return collect(range(0, $days - 1))
            ->map(function ($offset) use ($startDate, $rawData) {
                $date = $startDate->copy()->addDays($offset);
                $key  = $date->format('Y-m-d');

                return [
                    'label'     => $date->format('d/m'),
                    'success'   => (int) ($rawData[$key]->success ?? 0),
                    'pending'   => (int) ($rawData[$key]->pending ?? 0),
                    'cancelled' => (int) ($rawData[$key]->cancelled ?? 0),
                ];
            })
            ->toArray();
    }

    private function getRevenueChart(string $period): array
    {
        $days = $this->getDaysByPeriod($period);

        $startDate = now()->subDays($days - 1)->startOfDay();

        // Truy vấn tổng hợp doanh thu theo ngày, phân loại theo trạng thái
        $rawData = Appointment::query()
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->selectRaw("
            DATE(start_time) as date,
            SUM(CASE WHEN status = 'completed' THEN services.price ELSE 0 END) as actual,
            SUM(CASE WHEN status IN ('pending', 'confirmed') THEN services.price ELSE 0 END) as expected,
            SUM(CASE WHEN status = 'cancelled' THEN services.price ELSE 0 END) as lost
        ")
            ->where('start_time', '>=', $startDate)
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        return collect(range(0, $days - 1))
            ->map(function ($offset) use ($startDate, $rawData) {
                $date = $startDate->copy()->addDays($offset);
                $key  = $date->format('Y-m-d');

                return [
                    'label'    => $date->format('d/m'),
                    'actual'   => (int) ($rawData[$key]->actual ?? 0),
                    'expected' => (int) ($rawData[$key]->expected ?? 0),
                    'lost'    => (int) ($rawData[$key]->lost ?? 0),
                ];
            })
            ->toArray();
    }

    private function getTimelineDataByDay(string $date, array $config): array
    {
        $startTime = Carbon::parse($date . ' ' . $config['start']);
        $endTime   = Carbon::parse($date . ' ' . $config['end']);
        $interval  = (int) ($config['slot_interval'] ?? 60);

        $appointments = Appointment::query()
            ->with(['user:id,name', 'service:id,name', 'employee:id,name'])
            ->whereDate('start_time', $date)
            ->where('status', '!=', 'rejected')
            ->orderBy('start_time')
            ->get();

        $timeline = [];

        while ($startTime->lt($endTime)) {

            $slotStart = $startTime->copy();
            $slotEnd   = $slotStart->copy()->addMinutes($interval);

            // Chỉ lấy appointment nằm trong slot hiện tại
            $matched = $appointments->filter(function ($app) use ($slotStart, $slotEnd) {

                return $app->start_time >= $slotStart
                    && $app->start_time < $slotEnd;
            });

            $timeline[] = [
                'time'         => $slotStart->format('H:i'),
                'appointments' => $matched->values(),
            ];

            $startTime->addMinutes($interval);
        }

        return $timeline;
    }
}
