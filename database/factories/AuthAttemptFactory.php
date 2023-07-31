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
        $agent = UserAgent::inRandomOrder()->first();

        $i = 0;
        do {
            try {
                $i++;
                $ip = IpAddress::where('created_at', '>=', $agent->created_at)->inRandomOrder()->first()->id;
                break;
            } catch(\Exception $e) {
                echo("Ip Address couldn't found!");
            }

        } while($i > 10);

        return [
            'ip_address_id' => $ip,
            'user_agent_id' => $agent->id,
            'username' => $this->faker->name(),
            'event' => Arr::random(['login', 'register', 'admin']),
            'created_at' => $agent->created_at,
        ];
    }
}
