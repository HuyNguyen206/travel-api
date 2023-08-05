<?php

namespace Database\Factories;

use App\Models\Travel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => rand(200, 700),
            'name' => $this->faker->word,
            'start_date' => $startDate = $this->faker->date,
            'end_date' => Carbon::parse($startDate)->addDays(rand(1, 10)),
            'travel_id' => fn() => Travel::factory()->create()->id
        ];
    }
}
