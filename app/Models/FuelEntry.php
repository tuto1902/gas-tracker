<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelEntry extends Model
{
    protected $fillable = [
        'date',
        'odometer',
        'fuel_amount',
        'price_per_unit',
        'total_cost',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (FuelEntry $fuelEntry) {
            // Calculate fuel efficiency (mpg_kpl) using the odometer reading
            // form a previous entry or the inicial odometer reading of the
            // vehicle.
            // Formula
            // - (with previous entry): (current odometer - last odometer) / fuel amount
            // - (first entry): (current odometer - initial odometer) / fuel amount
            $previousEntry = $fuelEntry->vehicle->fuelEntries()->latest()->first();
            if ($previousEntry) {
                $fuelEntry->mpg_kpl = ($fuelEntry->odometer - $previousEntry->odometer) / $fuelEntry->fuel_amount;
            } else {
                $fuelEntry->mpg_kpl = ($fuelEntry->odometer - $fuelEntry->vehicle->initial_odometer) / $fuelEntry->fuel_amount;
            }
        });
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
