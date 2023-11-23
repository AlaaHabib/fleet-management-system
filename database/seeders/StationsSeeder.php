<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Cairo', 'Giza', 'AlFayyum', 'AlMinya', 'Asyut',
            'Sohag', 'Qena', 'Luxor', 'Aswan',
        ];

        foreach ($cities as $city) {
            // Create the station with the current city
             Station::create([
                'name' => $city,
            ]);
        }

    }
}
