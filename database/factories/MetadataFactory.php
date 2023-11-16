<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Metadata>
 */
class MetadataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_at' => fake()->dateTimeBetween('2023-10-01', '2023-10-31'),
            'field' => fake()->title(),
            'action' => fake()->text(),
            'old_value' => fake()->text(),
            'new_value' => fake()->text()
        ];
    }
}
