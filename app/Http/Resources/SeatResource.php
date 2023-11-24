<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SeatResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($seat) {
            return [
                'id'                         => $seat->id,
                'seat_number'                => $seat->seat_number,
            ];
        });
    }
}
