<?php

namespace Database\Seeders;

use App\Models\CrossoverStation;
use App\Models\Station;
use App\Models\Trip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripsSeeder extends Seeder
{
    private function generateRandomIncreasingArray(): array
    {
        $start = rand(1, 8);
        $length = max(2, rand(1, 8 - $start + 1));

        $randomArray = range($start, $start + $length - 1);

        return $randomArray;
    }



    public function run(): void
    {
        $stationsPerTrip = [];

        for ($i = 0; $i < 8; $i++) {
            $stationsPerTrip[] = $this->generateRandomIncreasingArray();
        }

        $this->createTrips($stationsPerTrip);
        $this->createCrossoverStations($stationsPerTrip);
    }

    private function createTrips(array $stations): void
    {
        foreach ($stations as $tripStations) {
            $startStationId = $tripStations[0];
            $endStationId = last($tripStations);

            $startStation = Station::findOrFail($startStationId);
            $endStation = Station::findOrFail($endStationId);

            $tripName = $startStation->name . ' to ' . $endStation->name;

            Trip::create([
                'name' => $tripName,
                'from_station_id' => $startStationId,
                'to_station_id' => $endStationId,
                'bus_id' => rand(1, 2),
            ]);
        }
    }


    public function createCrossoverStations(array $stations): void
    {
        foreach ($stations as $tripIndex => $tripStations) {
            $stationCount = count($tripStations);

            for ($j = 0; $j < $stationCount - 1; $j++) {
                $fromStationId = $tripStations[$j];
                $toStationId = $tripStations[$j + 1];

                CrossoverStation::create([
                    'trip_id' => $tripIndex + 1,
                    'from_station_id' => $fromStationId,
                    'to_station_id' => $toStationId,
                ]);
            }
        }
    }
}
