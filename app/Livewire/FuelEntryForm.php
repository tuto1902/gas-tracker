<?php

namespace App\Livewire;

use App\Models\FuelEntry;
use App\Models\Vehicle;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Illuminate\Support\Facades\Auth;

class FuelEntryForm extends Form
{
    public ?FuelEntry $fuelEntry = null;
    public ?Vehicle $vehicle = null;

    public ?Carbon $date = null;
    public ?float $odometer = null;
    public ?float $fuel_amount = null;
    public ?float $price_per_unit = null;
    public ?float $total_cost = null;

    public function rules(): array
    {
        $rules = [
            'date' => ['required', 'date'],
            'odometer' => [
                'required',
                'numeric',
                'min:0',
            ],
            'fuel_amount' => ['required', 'numeric', 'min:0'],
            'price_per_unit' => ['required', 'numeric', 'min:0'],
            'total_cost' => ['required', 'numeric', 'min:0'],
        ];

        // When creating a new fuel entry, add a rule to check if the odometer reading is greater than the previous reading
        if ($this->fuelEntry == null) {
            $rules['odometer'][] =function ($attribute, $value, $fail) {
                if ($this->vehicle && $this->vehicle->lastOdometer >= $value) {
                    $fail('The odometer reading must be greater than the previous reading of ' . $this->vehicle->lastOdometer . ' ' . $this->vehicle->distance_units);
                }
            };
        } else {
            // When updating a fuel entry, add a rule to check if the odometer reading is greater than the previous reading
            $rules['odometer'][] = function ($attribute, $value, $fail) {
                if ($value <= $this->fuelEntry->previousOdometer) {
                    $fail('The odometer reading must be greater than the previous reading of ' . $this->fuelEntry->previousOdometer . ' ' . $this->vehicle->distance_units);
                }
            };

            // Also, add a rule to check if the odometer reading is less than the next reading if it exists
            if ($this->fuelEntry->nextFuelEntry) {
                $rules['odometer'][] =function ($attribute, $value, $fail) {
                    if ($value >= $this->fuelEntry->nextOdometer) {
                        $fail('The odometer reading must be less than the next reading of ' . $this->fuelEntry->nextOdometer . ' ' . $this->vehicle->distance_units);
                    }
                };
            }
        }

        return $rules;
    }

    public function setVehicle(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
    }

    public function setFuelEntry(FuelEntry $fuelEntry): void
    {
        $this->fuelEntry = $fuelEntry;
        $this->date = $fuelEntry->date;
        // If the distance units of the vehicle are km, convert the fuel entry odometer from miles to kilometers
        if ($this->vehicle->distance_units === 'km') {
            $this->odometer = ceil($fuelEntry->odometer * 1.60934);
        } else {
            $this->odometer = $fuelEntry->odometer;
        }

        // If the volume units of the user are liters, convert the fuel entry fuel amount from gallons to liters
        if (Auth::user()->volume_units === 'l') {
            $this->fuel_amount = ceil($this->fuelEntry->fuelAmountConverted);
        } else {
            $this->fuel_amount = $fuelEntry->fuel_amount;
        }
        $this->price_per_unit = $fuelEntry->price_per_unit;
        $this->total_cost = $fuelEntry->total_cost;
    }

    public function store(): void
    {
        $this->validate();

        // Before storing the fuel entry, if the distance units of the vehicle are km, convert the fuel
        // entry odometer from kilometers to miles
        if ($this->vehicle->distance_units === 'km') {
            $this->odometer = $this->odometer * 0.621371;
        }

        // Before storing the fuel entry, if the volume unites of the user are l, convert the fuel entry
        // fuel amount from liters to gallons
        if (Auth::user()->volume_units === 'l') {
            $this->fuel_amount = $this->fuel_amount * 0.264172;
        }

        $this->vehicle->fuelEntries()->create($this->all());

        $this->reset();
    }

    public function update(): void
    {
        if (!$this->fuelEntry) {
            return;
        }

        $this->validate();

        // Before updating the fuel entry, if the distance units of the vehicle are km, convert the fuel
        // entry odometer from kilometers to miles
        if ($this->vehicle->distance_units === 'km') {
            $this->odometer = $this->odometer * 0.621371;
        }

        // Before updating the fuel entry, if the volume unites of the user are l, convert the fuel entry
        // fuel amount from liters to gallons
        if (Auth::user()->volume_units === 'l') {
            $this->fuel_amount = $this->fuel_amount * 0.264172;
        }
        $this->fuelEntry->update($this->all());

        $this->reset();
    }

    public function delete(): void
    {
        $this->fuelEntry->delete();

        $this->reset();
    }
}
