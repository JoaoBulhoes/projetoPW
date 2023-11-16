<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocumentPermission>
 */
class DocumentPermissionFactory extends Factory
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
            'view' => fake()->numberBetween(0,1),
            'modify' => fake()->numberBetween(0,1),
            'delete' => fake()->numberBetween(0,1),
            'download' => fake()->numberBetween(0,1),
            'document_id' => fake()->numberBetween(1,10),
            'user_id' => fake()->numberBetween(1,15)
        ];
    }
}
