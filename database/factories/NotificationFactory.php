<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sender' => fake()->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'recipient' => fake()->randomElement([1, 2, 3, 4, 5]),
            'message' => fake()->words(3, true),
            'url' => fake()->url(),
            'status' => 0,
        ];
    }
}
