<?php

namespace App\Models;

use App\Models\Area;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spatial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'area_id',
        'address',
        'latitude',
        'longitude',
        'is_deleted'
    ];

    protected $hidden = [
        'category_id',
        'area_id',
        'is_deleted'
    ];

    public function area() {
        return $this->belongsTo(Area::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
