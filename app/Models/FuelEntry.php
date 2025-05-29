<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelEntry extends Model
{
    protected static function booted(): void
    {
        static::creating(function (FuelEntry $fuelEntry) {
            // Calculate total cost using fuel_amount and price_per_unit

            // Calculate fuel efficiency (mpg_kpl) using the odometer reading
            // form a previous entry or the inicial odometer reading of the
            // vehicle.
            // Formula
            // - (with previous entry): (current odometer - last odometer) / fuel amount
            // - (first entry): (current odometer - initial odometer) / fuel amount
        });
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
