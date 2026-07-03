<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->sentence(3);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'category_id' => Category::factory(),
            'short_description' => fake()->sentence(),
            'long_description' => fake()->paragraph(),
            'duration' => 60,
            'max_slot' => 5,
            'price' => 500000,
            'image' => null,
        ];
    }
}