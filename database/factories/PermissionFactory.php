<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocumentPermission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_at' => fake()->dateTime(),
            'read' => fake()->boolean(50),
            'modify' => fake()->boolean(50),
            'delete' => fake()->boolean(50),
            'download' => fake()->boolean(50),
            'document_id' => fake()->numberBetween(1, 15),
            'user_id' => fake()->numberBetween(1,15)
        ];
    }
}
