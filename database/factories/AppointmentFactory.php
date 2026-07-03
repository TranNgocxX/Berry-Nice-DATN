<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\AppointmentDetail;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $service = Service::inRandomOrder()->first() ?? Service::factory()->create();
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        $startTime = Carbon::now()
            ->addDays(rand(1, 10))
            ->setHour(rand(8, 18))
            ->setMinute(0)
            ->setSecond(0);

        $endTime = (clone $startTime)->addMinutes($service->duration ?? 60);

        return [
            'user_id' => $user->id,
            'service_id' => $service->id,
            'employee_id' => null,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $this->faker->randomElement(['pending', 'confirmed']),
            'price' => $service->price ?? 100000,
            'total_price' => $service->price ?? 100000,
            'payment_method' => $this->faker->randomElement(['cash', 'qr']),
            'payment_status' => 'unpaid',
        ];
    }

    /**
     * Tự động tạo kèm dữ liệu chi tiết AppointmentDetail liên kết với User
     */
    public function withDetail(array $attributes = []): static
    {
        return $this->afterCreating(function (Appointment $appointment) use ($attributes) {
            // Lấy thông tin user có sẵn để đồng bộ hóa sang bảng chi tiết nếu cần
            $user = $appointment->user;

            AppointmentDetail::create(array_merge([
                'appointment_id' => $appointment->id,
                'customer_name'  => $user ? $user->name : $this->faker->name,
                'email'          => $user ? $user->email : $this->faker->safeEmail,
                'phone'          => $this->faker->phoneNumber,
                'address'        => $this->faker->address,
                'health_status'  => 'Bình thường',
                'notes'          => $this->faker->sentence,
            ], $attributes));
        });
    }

    /**
     * Appointment đã xác nhận
     */
    public function confirmed(): static
    {
        return $this->state(fn() => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Appointment đang chờ
     */
    public function pending(): static
    {
        return $this->state(fn() => [
            'status' => 'pending',
        ]);
    }

    public function withService($service): static
    {
        return $this->state(fn() => [
            'service_id' => $service->id,
            'price' => $service->price,
            'total_price' => $service->price,
        ]);
    }

    /**
     * Appointment có nhân viên
     */
    public function withEmployee($employeeId = null): static
    {
        return $this->state(fn() => [
            'employee_id' => $employeeId,
        ]);
    }

    /**
     * Slot cố định (dễ test)
     */
    public function fixedTime(string $time = '10:00'): static
    {
        return $this->state(function () use ($time) {
            $date = Carbon::tomorrow()->format('Y-m-d');

            $start = Carbon::parse("$date $time");
            $end = (clone $start)->addMinutes(60);

            return [
                'start_time' => $start,
                'end_time' => $end,
            ];
        });
    }
}
