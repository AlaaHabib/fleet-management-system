<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'next_to_id'];

    public function nextStation()
    {
        return $this->belongsTo(Station::class, 'next_to_id');
    }
}
