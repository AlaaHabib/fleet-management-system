<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'from_station_id', 'to_station_id', 'bus_id'];

    protected $fieldSearchable = [
        'name'
    ];
    public function scopeByStartEndStation($query, $start_station, $end_station)
    {
        $query
            ->whereHas('crossoverStations', function ($q) use ($start_station, $end_station) {
                $q->where(function ($subquery) use ($start_station, $end_station) {
                    $subquery->where('from_station_id', $start_station)
                        ->orWhere(function ($nestedSubquery) use ($start_station, $end_station) {
                            $nestedSubquery->where('from_station_id', '<=', $start_station)
                                ->where('to_station_id', '<=', $end_station);
                        });
                });
            });
    }

    public function scopeSearch($query, $searchParams)
    {
        $searchArray = explode(';', $searchParams);
        $hasValidCriteria = false; // Initialize a flag to track if any valid criteria were provided

        foreach ($searchArray as $search) {
            list($field, $value) = explode(':', $search);
            if (in_array($field, $this->fieldSearchable)) {
                $query->where($field, 'like', '%' . $value . '%');
                $hasValidCriteria = true; // Set the flag to true if at least one valid criteria is found
            }
        }

        // If no valid criteria were found, return an empty query result
        if (!$hasValidCriteria) {
            return $query->whereRaw('1 = 0');
        }

        return $query;
    }
    public function fromStation()
    {
        return $this->belongsTo(Station::class, 'from_station_id');
    }

    public function toStation()
    {
        return $this->belongsTo(Station::class, 'to_station_id');
    }
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function crossoverStations()
    {
        return $this->hasMany(CrossoverStation::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
