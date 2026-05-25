<?php

namespace Database\Factories;

use App\Models\ViewHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ViewHistory>
 */
class ViewHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id' => fake()->randomNumber(3),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
