<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Attributes\Session;
use Livewire\Component;

class FuelEntries extends Component
{
    #[Session]
    public $vehicleId;

    public $fuelEntries;

    public function mount()
    {
        $this->vehicleId = session()->get('vehicleId');
    }

    public function render()
    {
        session(['vehicleId' => $this->vehicleId]);
        $vehicle = Vehicle::find($this->vehicleId);
        $this->fuelEntries = $vehicle ? $vehicle->fuelEntries()->latest()->get() : collect();

        return view('livewire.fuel-entries');
    }
}
