<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAgent>
 */
class UserAgentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_agent' => $this->faker->userAgent(),
            'device' => Arr::random(['Web', 'iOS', 'Linux', 'Android']),
            'platform' => Arr::random(['Windows', 'iOS', 'Linux', 'Android']),
            'browser' => Arr::random(['Mozilla Firefox', 'Google Chrome', 'Safari']),
            'robot' => null,
            'disabled' => $this->faker->boolean(20),
            'location' => $this->faker->latitude . ', ' . $this->faker->longitude,
            'created_at' => now()->subHours(mt_rand(0, 750)),
        ];
    }
}
