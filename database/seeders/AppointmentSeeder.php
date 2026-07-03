<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        // Danh sách các lịch hẹn mẫu
        // Giả sử: User ID (4-7), Service ID (1-15), Employee ID (1-4)
        $appointments = [
            [
                'user_id' => 16, // Nguyễn Minh Anh
                'service_id' => 1, // Tẩy tế bào chết kim cương
                'employee_id' => 1, 
                'start_time' => Carbon::now()->subMonth(1)->setTime(9, 0),
                'status' => 'confirmed',
                'price' => 200000,
                'total_price' => 200000,
                'payment_method' => 'qr',
                'payment_status' => 'paid',
                'details' => [
                    'customer_name' => 'Nguyễn Minh Anh',
                    'phone' => '0911111111',
                    'health_status' => 'Da nhạy cảm, hơi khô',
                    'notes' => 'Khách muốn dùng phòng riêng'
                ]
            ],
            [
                'user_id' => 17, // Trần  Ngọc
                'service_id' => 5, // Gội đầu truyền thống
                'employee_id' => 3,
                'start_time' => Carbon::now()->subMonth(2)->setTime(14, 30),
                'status' => 'completed',
                'price' => 150000,
                'total_price' => 150000,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
                'details' => [
                    'customer_name' => 'Trần Thị Ngọc',
                    'phone' => '0922222222',
                    'health_status' => 'Bình thường',
                    'notes' => 'Gội kỹ phần gáy'
                ]
            ],
            [
                'user_id' => 21, // Lê Nga
                'service_id' => 8, // Massage Body&Soul
                'employee_id' => 6,
                'start_time' => Carbon::now()->addHours(1),
                'status' => 'pending',
                'price' => 300000,
                'total_price' => 300000,
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
                'details' => [
                    'customer_name' => 'Lê Nga',
                    'phone' => '0933333333',
                    'health_status' => 'Đau mỏi vai gáy nặng',
                    'notes' => 'Cần nhân viên tay nghề cao'
                ]
            ],
            [
                'user_id' => 19, // Phạm Thị Dung
                'service_id' => 18, // Tắm trắng sữa dê
                'employee_id' => 7,
                'start_time' => Carbon::now()->subDays(2)->setTime(10, 0),
                'status' => 'pending',
                'price' => 250000,
                'total_price' => 225000,
                'payment_method' => 'qr',
                'payment_status' => 'unpaid',
                'details' => [
                    'customer_name' => 'Phạm Thị Dung',
                    'phone' => '0944444444',
                    'health_status' => 'Bình thường',
                    'notes' => 'Khách lần đầu đến Spa'
                ]
            ],
            [
                'user_id' => 17, 
                'service_id' => 11, 
                'employee_id' => 8,
                'start_time' => Carbon::now()->addWeek()->setTime(10, 0),
                'status' => 'pending',
                'price' => 200000,
                'total_price' => 200000,
                'payment_method' => 'qr',
                'payment_status' => 'unpaid',
                'details' => [
                    'customer_name' => 'Khách Lan',
                    'phone' => '0944444444',
                    'health_status' => 'Bình thường',
                    'notes' => 'Khách lần đầu đến Spa'
                ]
            ],
            [
                'user_id' => 20, 
                'service_id' => 14,
                'employee_id' => 2,
                'start_time' => Carbon::now()->subWeek()->setTime(10, 0),
                'status' => 'pending',
                'price' => 150000,
                'total_price' => 150000,
                'payment_method' => 'qr',
                'payment_status' => 'unpaid',
                'details' => [
                    'customer_name' => 'Khách Mai',
                    'phone' => '0944444444',
                    'health_status' => 'Bình thường',
                    'notes' => 'Khách lần đầu đến Spa'
                ]
            ],
        ];

        foreach ($appointments as $item) {
            // Lấy thông tin dịch vụ để tính End Time tự động (dựa trên duration)
            $service = DB::table('services')->where('id', $item['service_id'])->first();
            $endTime = Carbon::parse($item['start_time'])->addMinutes($service->duration ?? 60);

            // 1. Chèn vào bảng appointments
            $appointmentId = DB::table('appointments')->insertGetId([
                'user_id'        => $item['user_id'],
                'service_id'     => $item['service_id'],
                'employee_id'    => $item['employee_id'],
                'start_time'     => $item['start_time'],
                'end_time'       => $endTime,
                'status'         => $item['status'],
                'price'          => $item['price'],
                'total_price'    => $item['total_price'],
                'payment_method' => $item['payment_method'],
                'payment_status' => $item['payment_status'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // 2. Chèn vào bảng appointment_details
            DB::table('appointment_details')->insert([
                'appointment_id' => $appointmentId,
                'customer_name'  => $item['details']['customer_name'],
                'email'          => $item['details']['customer_name'] . '@example.com', // Tạo email giả dựa trên tên khách
                'phone'          => $item['details']['phone'],
                'health_status'  => $item['details']['health_status'],
                'notes'          => $item['details']['notes'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}