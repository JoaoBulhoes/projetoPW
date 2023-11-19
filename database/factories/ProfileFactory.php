<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'create_user' => fake()->boolean(50),
            'manage_user' => fake()->boolean(50),
            'delete_user' => fake()->boolean(50),
            'create_department' => fake()->boolean(50),
            'delete_department' => fake()->boolean(50),
            'access_admin_dashboard' => fake()->boolean(50),
        ];
    }
}
