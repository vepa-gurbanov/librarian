<?php

namespace Database\Factories;

use App\Models\IpAddress;
use App\Models\UserAgent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuthAttempt>
 */
class AuthAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = now()->subHours(mt_rand(0, 750));
        $ip = IpAddress::where('created_at', '>=', $createdAt)->inRandomOrder()->first()->id;
        $agent = UserAgent::where('created_at', '>=', $createdAt)->inRandomOrder()->first()->id;
        return [
            'ip_address_id' => $ip,
            'user_agent_id' => $agent,
            'username' => $this->faker->name(),
            'event' => Arr::random(['login', 'register', 'admin']),
            'created_at' => $createdAt,
        ];
    }
}
