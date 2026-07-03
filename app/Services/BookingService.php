<?php

namespace App\Services;

use App\Models\Service;
use App\Models\Appointment;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function createBooking(array $data, $userId)
    {
        return DB::transaction(function () use ($data, $userId) {
            $service = Service::findOrFail($data['service_id']);

            $startTime = Carbon::parse($data['start_time']);

            // Ktra slot trống
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
            $booking = Appointment::create([
                'user_id' => $userId,
                'service_id' => $service->id,
                'employee_id' => null,
                'price' => $service->price,
                'total_price' => $service->price,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => 'pending',
                'payment_method' => $data['payment_method'],
                'payment_status' => 'unpaid'
            ]);

            // Tạo chi tiết lịch hẹn 
            $booking->appointmentDetail()->create([
                'customer_name' => $data['customer_name'],
                'email'        => $data['email'],
                'phone'         => $data['phone'],
                'address'       => $data['address'] ?? null,
                'health_status' => $data['health_status'] ?? null,
                'notes'         => $data['notes'] ?? null
            ]);

            return $booking;
        });
    }

    public function confirmAppointment($appointment, $employeeId)
    {
        // Logic ktra trùng lịch NV
        $busy = Appointment::where('employee_id', $employeeId)
            ->where('status', 'confirmed') // chỉ ktra những lịch đã xác nhận
            ->where(function ($q) use ($appointment) {
                $q->where(function ($query) use ($appointment) { // ktra trùng giờ
                    $query->where('start_time', '<', $appointment->end_time)
                        ->where('end_time', '>', $appointment->start_time);
                });
            })
            ->exists();

        if ($busy) {
            throw new \Exception('Nhân viên này đã có lịch hẹn khác trùng vào khung giờ này.');
        }

        // Cập nhật lịch hẹn với NV và trạng thái đã xác nhận
        $appointment->update([
            'employee_id' => $employeeId,
            'status' => 'confirmed'
        ]);
    }

    // Lấy danh sách NV có kỹ năng phù hợp và check bận
    public function getEmployees($appointment)
    {
        return Employee::query()
            // lọc NV có kỹ năng phù hợp
            ->whereHas('services', function ($q) use ($appointment) {
                $q->where('services.id', $appointment->service_id);
            })
            // sd Scope trong Employee để check bận 
            ->withBusyStatus($appointment->start_time, $appointment->end_time)
            ->get();
    }

}
