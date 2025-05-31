<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Form;
use Livewire\WithPagination;

class VehicleForm extends Form
{
    public ?Vehicle $vehicle = null;

    public ?string $nickname = null;
    public string $make = '';
    public string $model = '';
    public ?int $year = null;
    public string $distance_units = 'miles';
    public ?int $initial_odometer = null;

    public function rules(): array
    {
        return [
            'make' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'initial_odometer' => ['required', 'integer', 'min:0'],
            'distance_units' => ['required', 'string', 'in:miles,km'],
        ];
    }

    public function setVehicle(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
        $this->nickname = $vehicle->nickname ?? null;
        $this->make = $vehicle->make;
        $this->model = $vehicle->model;
        $this->year = $vehicle->year;
        $this->initial_odometer = $vehicle->initial_odometer;
        $this->distance_units = $vehicle->distance_units;
    }

    public function store(): void
    {
        $this->validate();

        Auth::user()->vehicles()->create($this->all());

        $this->reset();
    }

    public function update(): void
    {
        if (!$this->vehicle) {
            return;
        }

        $this->validate();

        $this->vehicle->update($this->all());

        $this->reset();
    }

    public function delete(): void
    {
        $this->vehicle->delete();

        $this->reset();
    }
}
