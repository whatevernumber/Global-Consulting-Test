<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word,
            //
        ];
    }

    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'value' => 'available',
        ]);
    }

    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'value' => 'unavailable',
        ]);
    }
}
