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
            $station = Station::create([
                'name' => $city,
            ]);
        }
        $stations = Station::all();
        foreach ($stations as $index => $station) {
            $nextIndex = $index + 1;
            $station->update(['next_to_id' => $nextIndex < count($stations) ? $stations[$nextIndex]->id : null]);
        }
    }
}
