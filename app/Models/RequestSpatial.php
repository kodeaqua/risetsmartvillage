<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestSpatial extends Model
{
    use HasFactory;

    protected $fillable = [
        'spatial_id',
        'name',
        'description',
        'latlong'
    ];

    protected $hidden = [
        'spatial_id',
    ];
}
