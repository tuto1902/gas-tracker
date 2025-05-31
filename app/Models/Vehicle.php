<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'nickname',
        'make',
        'model',
        'year',
        'initial_odometer',
        'distance_units',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fuelEntries()
    {
        return $this->hasMany(FuelEntry::class);
    }

    public function lastOdometer(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->fuelEntries()->latest('odometer')->first()?->odometer ?? $this->initial_odometer;
            },
        );
    }
}
