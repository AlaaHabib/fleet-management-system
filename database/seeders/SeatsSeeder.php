<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\CrossoverStation;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Trip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $crossoverStations = CrossoverStation::all();

        foreach ($crossoverStations as $crossoverStation) {
            for ($i = 1; $i <= 12; $i++) {
                Seat::updateOrCreate([
                    'crossover_station_id' => $crossoverStation->id,
                    'seat_number' => 'Seat ' . $i,
                ]);
            }
        }
    }
}
