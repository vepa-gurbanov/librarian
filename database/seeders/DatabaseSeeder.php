<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function authFactory(): array
    {
        return [
            \App\Models\User::factory(25)->create(),
            \App\Models\Reader::factory(100)->create(),
            \App\Models\IpAddress::factory(100)->create(),
            \App\Models\UserAgent::factory(50)->create(),
            \App\Models\AuthAttempt::factory(25)->create(),
        ];
    }
    public function run(): void
    {
        $this->authFactory();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
