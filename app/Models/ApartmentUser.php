<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ApartmentUser extends Pivot
{
    public $table = 'apartment_user';
    public $timestamps = true;

    public $fillable = [
        'user_id',
        'apartment_id',
        'is_favorite',
    ];

    public $casts = [
        'is_favorite' => 'boolean',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
