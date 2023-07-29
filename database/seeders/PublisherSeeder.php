<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objs = [
            'Global Vision Publishing House',
            'Literacy House',
            'Pacific Books International 1',
            'Peacock Books',
            'Empire Books International ',
            'National Book Agency Pvt Ltd',
            'National Book Foundation (Regional Office)',
        ];

        foreach ($objs as $obj) {
            $publisher = new Publisher();
            $publisher->name = $obj;
            $publisher->slug = str($obj)->slug('_');
            $publisher->save();
        }
    }
}
