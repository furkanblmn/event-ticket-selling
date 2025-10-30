<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    protected $fillable = [
        'name',
        'address',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }
}
