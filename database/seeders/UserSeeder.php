<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // XOÁ DL CŨ NẾU CHẠY THÊM LỆNH SEED: DB::table('users')->truncate(); 

        User::insert([
            // ===== NHÓM ADMIN =====
            [
                'name' => 'Trần Thị Ngọc - Admin',
                'birthday' => '2004-01-01',
                'avt' => null,
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0900000001',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Trần Văn Đức - Admin',
                'birthday' => '1990-02-01',
                'avt' => null,
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0900000002',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nguyễn Khải Minh - Admin',
                'birthday' => '1990-03-01',
                'avt' => null,
                'email' => 'admin3@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0900000003',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ===== NHÓM USER (KHÁCH HÀNG) =====
            [
                'name' => 'Nguyễn Minh Anh',
                'birthday' => '2001-04-01',
                'avt' => null,
                'email' => 'anh@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0911111111',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Trần Thị Ngọc',
                'birthday' => null,
                'avt' => null,
                'email' => 'ngoc@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0922222222',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lê Nga',
                'birthday' => '2000-05-01',
                'avt' => null,
                'email' => 'nga@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0933333333',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phạm Thị Dung',
                'birthday' => null,
                'avt' => null,
                'email' => 'dung@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0944444444',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ===== + 18 USER =====
            ['name'=>'Lan','birthday'=>null,'avt'=>null,'email'=>'lan@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000001','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Mai','birthday'=>null,'avt'=>null,'email'=>'mai@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000002','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Hà','birthday'=>null,'avt'=>null,'email'=>'ha@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000003','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Vy','birthday'=>null,'avt'=>null,'email'=>'vy@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000004','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'My','birthday'=>null,'avt'=>null,'email'=>'my@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000005','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Kim','birthday'=>null,'avt'=>null,'email'=>'kim@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000006','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Thảo','birthday'=>null,'avt'=>null,'email'=>'thao@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000007','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Hương','birthday'=>null,'avt'=>null,'email'=>'huong@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000008','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Yến','birthday'=>null,'avt'=>null,'email'=>'yen@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000009','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Nhung','birthday'=>null,'avt'=>null,'email'=>'nhung@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000010','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Tú','birthday'=>null,'avt'=>null,'email'=>'tu@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000012','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Loan','birthday'=>null,'avt'=>null,'email'=>'loan@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000013','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Diễm','birthday'=>null,'avt'=>null,'email'=>'diem@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000014','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Quỳnh','birthday'=>null,'avt'=>null,'email'=>'quynh@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000017','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Ngọc','birthday'=>null,'avt'=>null,'email'=>'ngoc2@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000018','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Ly','birthday'=>null,'avt'=>null,'email'=>'ly@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000019','role'=>'user','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Oanh','birthday'=>null,'avt'=>null,'email'=>'oanh@gmail.com','password'=>Hash::make('123456'),'phone'=>'0950000020','role'=>'user','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
