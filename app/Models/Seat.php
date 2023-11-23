<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['seat_number', 'crossover_station_id', 'is_booked'];

   
    public function crossoverStation()
    {
        return $this->belongsTo(CrossoverStation::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
