<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 6,
            'name' => fake()->name(),
            'thesis_title' => 'My awesome thesis title',
            'venue_id' => 1,
            'start' => now(),
            'end' => now(),
            'status' => Team::PENDING,
        ];
    }
}
