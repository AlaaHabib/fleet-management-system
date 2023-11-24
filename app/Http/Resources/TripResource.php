<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TripResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($trip) use ($request) {
            $bookedSeats = $trip->bookings()
                ->where('from_station_id', '<=',$request->query('start_station'))
                ->OrWhere('to_station_id','>=' ,$request->query('start_station'))
                ->pluck('seat_id')
                ->toArray();

            $availableSeats = $trip->bus->seats->reject(function ($seat) use ($bookedSeats) {
                return in_array($seat->id, $bookedSeats);
            });

            return [
                'id' => $trip->id,
                'name' => $trip->name,
                'start_station_id' => $trip->fromStation->id,
                'start_station' => $trip->fromStation->name,
                'end_station_id' => $trip->toStation->id,
                'end_station' => $trip->toStation->name,
                'bus_id' => $trip->bus->id,
                'bus' => $trip->bus->plate_number,
                'total_seats' => $trip->bus->seats->count(),
                'available_seats' => $availableSeats->count(),
                'seats' => new SeatResource($availableSeats),
            ];
        });
    }
}
