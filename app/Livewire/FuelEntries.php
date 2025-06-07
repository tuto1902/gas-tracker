<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Component;

class FuelEntries extends Component
{
    public Vehicle $vehicle;
    public $fuelEntries;

    public function mount(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
        $this->fuelEntries = $vehicle->fuelEntries()->latest()->get();
    }


    public function render()
    {
        return view('livewire.fuel-entries');
    }
}
