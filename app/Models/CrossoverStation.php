<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrossoverStation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['from_station_id', 'to_station_id', 'trip_id'];


    public function trip()
    {

        return $this->belongsTo(Trip::class);
    }
    public function seats()
    {

        return $this->hasMany(Seat::class);
    }
}
