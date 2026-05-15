<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Chăm sóc da mặt', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chăm sóc tóc', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Massage thư giãn', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tẩy da chết', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Waxing', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tắm trắng thảo mộc', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
