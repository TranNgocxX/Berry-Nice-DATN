<?php

namespace App\Services;

use App\Models\Service;
use App\Models\Appointment;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function createAppointment(array $data, $userId)
    {
        return DB::transaction(function () use ($data, $userId) {
            $service = Service::findOrFail($data['service_id']);

            $startTime = Carbon::parse($data['start_time']);

            // Kiểm tra slot trống
            $count = Appointment::where('service_id', $service->id)
                ->where('start_time', $startTime)
                ->whereIn('status', ['pending', 'confirmed'])
                ->lockForUpdate() 
                ->count();

            if ($count >= $service->max_slot) {
                throw new \Exception('Khung giờ này đã đủ số lượng khách. Vui lòng chọn giờ khác.');
            }

            $endTime = $startTime->copy()->addMinutes($service->duration);

            // Tạo lịch hẹn
            $appointment = Appointment::create([
                'user_id' => $userId,
                'service_id' => $service->id,
                'employee_id' => null,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => 'pending',
                'payment_method' => $data['payment_method'],
                'payment_status' => 'unpaid'
            ]);

            // Tạo chi tiết lịch hẹn 
            $appointment->detail()->create([
                'customer_name' => $data['customer_name'],
                'phone'         => $data['phone'],
                'health_status' => $data['health_status'] ?? null,
                'notes'         => $data['notes'] ?? null
            ]);

            return $appointment;
        });
    }

    public function confirmAppointment($appointment, $employeeId)
    {
        // Logic kiểm tra trùng lịch nhân viên
        $busy = Appointment::where('employee_id', $employeeId)
            ->where('status', 'confirmed')
            ->where(function ($q) use ($appointment) {
                $q->where(function ($query) use ($appointment) {
                    $query->where('start_time', '<', $appointment->end_time)
                        ->where('end_time', '>', $appointment->start_time);
                });
            })
            ->exists();

        if ($busy) {
            throw new \Exception('Nhân viên này đã có lịch hẹn khác trùng vào khung giờ này.');
        }

        $appointment->update([
            'employee_id' => $employeeId,
            'status' => 'confirmed'
        ]);
    }

    public function getEmployees($appointment)
    {
        return Employee::query()
            // lọc nhân viên có kỹ năng phù hợp
            ->whereHas('services', function ($q) use ($appointment) {
                $q->where('services.id', $appointment->service_id);
            })
            // sd Scope để check bận (trả về field is_busy kiểu boolean)
            ->withBusyStatus($appointment->start_time, $appointment->end_time)
            ->get();
    }

    public function getTopServices($limit = 5)
    {
        return Service::withCount(['appointments' => function ($query) {
            $query->whereIn('status', ['confirmed', 'completed']);
        }])
            ->orderByDesc('appointments_count')
            ->take($limit)
            ->get();
    }
}
