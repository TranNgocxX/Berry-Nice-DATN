<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => '09' . fake()->numerify('########'),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}