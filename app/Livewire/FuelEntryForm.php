<?php

namespace App\Livewire;

use App\Models\FuelEntry;
use App\Models\Vehicle;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Form;

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

        // If the fuel entry is not being updated, add a rule to check if the odometer reading is greater than the previous reading
        if ($this->fuelEntry == null) {
            $rules['odometer'][] =function ($attribute, $value, $fail) {
                if ($this->vehicle && $this->vehicle->lastOdometer >= $value) {
                    $fail('The odometer reading must be greater than the previous reading of ' . $this->vehicle->lastOdometer . ' ' . $this->vehicle->distance_units);
                }
            };
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
        $this->odometer = $fuelEntry->odometer;
        $this->fuel_amount = $fuelEntry->fuel_amount;
        $this->price_per_unit = $fuelEntry->price_per_unit;
        $this->total_cost = $fuelEntry->total_cost;
    }

    public function store(): void
    {
        $this->validate();

        $this->vehicle->fuelEntries()->create($this->all());

        $this->reset();
    }

    public function update(): void
    {
        if (!$this->fuelEntry) {
            return;
        }

        $this->validate();

        $this->fuelEntry->update($this->all());

        $this->reset();
    }

    public function delete(): void
    {
        $this->fuelEntry->delete();

        $this->reset();
    }
}
