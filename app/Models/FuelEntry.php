<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;

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

    public function fuelAmountConverted(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (Auth::user()->volume_units === 'l') {
                    return $this->fuel_amount * 3.78541;
                }

                return $this->fuel_amount;
            },
        );
    }

    // Return the last fuel entry record based on the current record creation date
    public function previousOdometer(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->vehicle->fuelEntries()->where('created_at', '<', $this->created_at)->latest('odometer')->first() ?? $this->vehicle->initial_odometer;
            },
        );
    }

    // Return the next fuel entry record based on the current record creation date
    public function nextOdometer(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->vehicle->fuelEntries()->where('created_at', '>', $this->created_at)->orderBy('odometer')->first();
            },
        );
    }

    // Return the fuel efficiency using the previous odometer reading and the fuel amount. If the user
    // has set the distance units to kilometers, convert the odometer reading to kilometers and the fuel amount to liters
    // before calculating the fuel efficiency.
    public function fuelEfficiency(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (Auth::user()->distance_units === 'km') {
                    $differenceInKilometers = ($this->odometer - $this->previousOdometer) * 1.60934;
                    return $differenceInKilometers / $this->fuelAmountConverted;
                }

                return ($this->odometer - $this->previousOdometer) / $this->fuel_amount;
            },
        );
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
