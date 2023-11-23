<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'from_station_id', 'to_station_id' , 'crossover_station_ids'];

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

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
