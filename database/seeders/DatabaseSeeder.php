<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Publisher;
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


    public function bookFactory(): array
    {
        return [
            $this->call([
                CategorySeeder::class,
                PublisherSeeder::class,
                AttributeValueSeeder::class,
            ]),
            \App\Models\Author::factory(25)->create(),
            \App\Models\Book::factory(200)->create(),
            \App\Models\Review::factory(250)->create(),
            $this->call(ShelfSeeder::class),
        ];
    }


    public function registrationFactory(): array
    {
        return [
            \App\Models\Registration::factory(250)->create(),
        ];
    }


    public function run(): void
    {
        Book::disableSearchSyncing();

        $this->authFactory();
        $this->bookFactory();
        $this->registrationFactory();

        Book::all()->searchable();
        Book::enableSearchSyncing();

    }
}
