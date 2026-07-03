<?php

namespace App\Services;

use App\Models\Service;
use Carbon\Carbon;

class SlotService
{
    public function getAvailableSlots($serviceId, $date)
    {
        // Xác định khoảng thời gian của ngày đó
        $dayStart = Carbon::parse($date)->startOfDay();
        $dayEnd = $dayStart->copy()->endOfDay();

        // Lấy dịch vụ cùng các lịch hẹn đã đặt trong ngày đó, chỉ lấy những lịch hẹn 'pending', 'confirmed' để tính slot trống
        $service = Service::with(['appointments' => function ($query) use ($dayStart, $dayEnd) {
            $query->whereIn('status', ['pending', 'confirmed'])
                  ->whereBetween('start_time', [$dayStart, $dayEnd]);
        }])->findOrFail($serviceId);

        // Xđ khoảng thời gian làm việc của spa trong ngày 
        $now = Carbon::now();
        $slotInterval = (int) config('spa.working_hours.slot_interval', 30);
        
        $currentTime = $dayStart->copy()->setTimeFromTimeString(config('spa.working_hours.start', '08:00'));
        $endTimeLimit = $dayStart->copy()->setTimeFromTimeString(config('spa.working_hours.end', '22:00'));

        $allSlots = [];

        // Sinh slot từ giờ bắt đầu đến giờ kết thúc, cách nhau $slotInterval (30) phút
        while ($currentTime->copy()->addMinutes($service->duration)->lte($endTimeLimit)) {
            $slotStart = $currentTime->copy();
            $slotEnd = $slotStart->copy()->addMinutes($service->duration);

            // Đếm số lịch trùng 
            $overlapCount = $service->appointments->filter(fn($app) => 
                $app->start_time->lt($slotEnd) && $app->end_time->gt($slotStart)
            )->count();

            // Xác định slot có phải là quá khứ hay 0, và có còn slot trống hay 0
            $isPast = $slotStart->lt($now);
            $hasOverlap = $overlapCount >= $service->max_slot;

            $allSlots[] = [
                'time'      => $slotStart->format('H:i'),
                'is_past'   => $isPast, 
                'available' => !$isPast && !$hasOverlap,
                'datetime'  => $slotStart->toDateTimeString(), 
            ];

            $currentTime->addMinutes($slotInterval);
        }

        return $allSlots;
    }
}