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
            ['name' => 'Chăm sóc da mặt', 'slug' => 'cham-soc-da-mat', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chăm sóc tóc', 'slug' => 'cham-soc-toc', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Massage thư giãn', 'slug' => 'massage-thu-gian', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tẩy da chết', 'slug' => 'tay-da-chet', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Waxing', 'slug' => 'waxing', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tắm trắng thảo mộc', 'slug' => 'tam-trang-thao-moc', 'description' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
