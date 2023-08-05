<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TravelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_public' => false,
            'name' =>$this->faker->word,
            'description' =>$this->faker->paragraph,
            'number_of_days' => rand(1, 20)
        ];
    }

    public function public(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_public' => true,
            ];
        });
    }
}
