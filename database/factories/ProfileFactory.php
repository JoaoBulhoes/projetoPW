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
            'created_at' => fake()->dateTime(),
            'alterar_foto_perfil' => fake()->numberBetween(0,1),
            'alterar_username' => fake()->numberBetween(0,1),
            'alterar_email' => fake()->numberBetween(0,1),
            'user_id' => fake()->unique()->numberBetween(1,15)
        ];
    }
}
