<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tạo dữ liệu mẫu cho bảng employees
        $employees = [
            ['name' => 'Nguyễn Anh', 'phone' => '0901234561', 'email' => 'nhanvien1@gmail.com'],
            ['name' => 'Minh Lan', 'phone' => '0901234562', 'email' => 'nhanvien2@gmail.com'],
            ['name' => 'Lê Phương', 'phone' => '0901234563', 'email' => 'nhanvien3@gmail.com'],
            ['name' => 'Bé Phương', 'phone' => '0901234564', 'email' => 'nhanvien4@gmail.com'],
            ['name' => 'Nga Nguyễn', 'phone' => '0901234565', 'email' => 'nhanvien5@gmail.com'],
            ['name' => 'Vũ Thu', 'phone' => '0901234566', 'email' => 'nhanvien6@gmail.com'],
            ['name' => 'Ngô Kiều', 'phone' => '0901234567', 'email' => 'nhanvien7@gmail.com'],
            ['name' => 'Phạm Hương', 'phone' => '0901234568', 'email' => 'nhanvien8@gmail.com'],
            ['name' => 'Trần Mai', 'phone' => '0901234569', 'email' => 'nhanvien9@gmail.com'],
            ['name' => 'Đỗ Hạnh', 'phone' => '0901234570', 'email' => 'nhanvien10@gmail.com'],
            ['name' => 'Phan Thảo', 'phone' => '0901234571', 'email' => 'nhanvien11@gmail.com'],
            ['name' => 'Lý Hương', 'phone' => '0901234572', 'email' => 'nhanvien12@gmail.com'],
        ];

        foreach ($employees as $emp) {
            DB::table('employees')->insert(array_merge($emp, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 2. Gán kỹ năng cho nhân viên (Bảng trung gian employee_services)
        // Giả sử bạn đã có dữ liệu trong bảng services (ID từ 1 đến 5)
        // Nếu chưa có bảng services, bước này sẽ bị lỗi. 

        // 2. Gán kỹ năng cho nhân viên (Bảng trung gian employee_services)
        DB::table('employee_services')->insert([
            // Nhân viên 1 làm được dịch vụ 1,2,3,4
            ['employee_id' => 1, 'service_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 1, 'service_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 1, 'service_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 1, 'service_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            // Nhân viên 2 làm được dịch vụ 1,2,3,4,14
            ['employee_id' => 2, 'service_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 2, 'service_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 2, 'service_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 2, 'service_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 2, 'service_id' => 14, 'created_at' => now(), 'updated_at' => now()],

            // Nhân viên 3 làm được dịch vụ 4,5,12,14,17
            ['employee_id' => 3, 'service_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 3, 'service_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 3, 'service_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 3, 'service_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 3, 'service_id' => 17, 'created_at' => now(), 'updated_at' => now()],

            // Nhân viên 4 làm được tất cả 5,6,7,13,14
            ['employee_id' => 4, 'service_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 4, 'service_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 4, 'service_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 4, 'service_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 4, 'service_id' => 14, 'created_at' => now(), 'updated_at' => now()],

            ['employee_id' => 5, 'service_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 5, 'service_id' => 7, 'created_at' => now(), 'updated_at' => now()],

            ['employee_id' => 6, 'service_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 6, 'service_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 6, 'service_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 6, 'service_id' => 10, 'created_at' => now(), 'updated_at' => now()],


            ['employee_id' => 7, 'service_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 7, 'service_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 7, 'service_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 7, 'service_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 7, 'service_id' => 18, 'created_at' => now(), 'updated_at' => now()],


            ['employee_id' => 8, 'service_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 8, 'service_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 8, 'service_id' => 13, 'created_at' => now(), 'updated_at' => now()],

            ['employee_id' => 9, 'service_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 9, 'service_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 9, 'service_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 9, 'service_id' => 19, 'created_at' => now(), 'updated_at' => now()],

            ['employee_id' => 10, 'service_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 10, 'service_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 10, 'service_id' => 19, 'created_at' => now(), 'updated_at' => now()],


            ['employee_id' => 11, 'service_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 11, 'service_id' => 16, 'created_at' => now(), 'updated_at' => now()],

            ['employee_id' => 12, 'service_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 12, 'service_id' => 16, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
