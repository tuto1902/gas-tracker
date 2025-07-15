<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Illuminate\View\View;
use Livewire\Component;

class Vehicles extends Component
{
    public $vehicles;

    public function mount(): void
    {
        $this->vehicles = Vehicle::all();
    }

    public function render(): View
    {
        return view('livewire.vehicles');
    }
}
