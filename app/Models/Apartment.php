<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'published_at',
        'link',
        'city',
        'district',
        'street',
        'rooms',
        'floor',
        'm2',
        'price',
        'price_per_m2',
        'series',
        'latitude',
        'longitude',
    ];
}
