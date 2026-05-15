<?php

namespace App\Services;

use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;

class SlotService
{
    public function getAvailableSlots($serviceId, $date)
    {
        // Lấy thông tin DV để biết thời lượng và số slot tối đa
        $service = Service::findOrFail($serviceId);
        $dayStart = Carbon::parse($date)->startOfDay();
        $dayEnd = Carbon::parse($date)->endOfDay();
        $now = Carbon::now();

        // Lấy tất cả lịch hẹn đã đặt cho DV này trong ngày đã chọn (trạng thái pending hoặc confirmed)
        $existingAppointments = Appointment::where('service_id', $serviceId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereBetween('start_time', [$dayStart, $dayEnd])
            ->get(['start_time', 'end_time']);

        $allSlots = [];
        $currentTime = Carbon::createFromTime(8, 0);
        $endTimeLimit = Carbon::createFromTime(22, 0);

        while ($currentTime->copy()->addMinutes($service->duration) <= $endTimeLimit) {
            $slotStart = $dayStart->copy()->setTime( $currentTime->hour, $currentTime->minute);
            $slotEnd = $slotStart->copy()->addMinutes($service->duration);

            // Kiểm tra khung giờ có nằm trong quá khứ 0
            $isPast = $slotStart->lessThan($now);
            // Đếm số lượng lịch hẹn trùng với khung giờ này 
            $overlapCount = $existingAppointments->filter(function ($app) use ($slotStart, $slotEnd) {
                return $app->start_time < $slotEnd && $app->end_time > $slotStart;
            })->count();

            $allSlots[] = [
                'time' => $currentTime->format('H:i'),
                'available' => !$isPast && ($overlapCount < $service->max_slot),
            ];

            $currentTime->addMinutes(30);
        }

        return $allSlots;
    }
}
