<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

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
            $differenceInKilometers = ($fuelEntry->odometer - $fuelEntry->latestOdometer) * 1.60934;
            $differenceInMiles = $fuelEntry->odometer - $fuelEntry->latestOdometer;
            $fuelAmounInLiters = $fuelEntry->fuel_amount * 3.78541;
            $fuelAmountInGallons = $fuelEntry->fuel_amount;

            $kilometersPerLiter = $differenceInKilometers / $fuelAmounInLiters;
            $milesPerGallon = $differenceInMiles / $fuelAmountInGallons;

            $fuelEntry->kpl = Number::format($kilometersPerLiter, 2);
            $fuelEntry->mpg = Number::format($milesPerGallon, 2);
        });
    }

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
                return $this->vehicle->fuelEntries()->where('created_at', '<', $this->created_at)->latest('odometer')->first()?->odometer ?? $this->vehicle->initial_odometer;
            },
        );
    }

    // Return the next fuel entry record based on the current record creation date
    public function nextOdometer(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->vehicle->fuelEntries()->where('created_at', '>', $this->created_at)->orderBy('odometer')->first()?->odometer;
            },
        );
    }

    // Return the latest fuel entry record
    public function latestOdometer(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->vehicle->fuelEntries()->latest('odometer')->first()?->odometer;
            }
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
                    // $differenceInKilometers = ($this->odometer - $this->previousOdometer) * 1.60934;
                    // return $differenceInKilometers / $this->fuelAmountConverted;
                    return $this->kpl;
                }

                // return ($this->odometer - $this->previousOdometer) / $this->fuel_amount;
                return $this->mpg;
            },
        );
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
