<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Livewire\Attributes\Session;
use Livewire\Component;

class Dashboard extends Component
{
    public array $stat = [];

    #[Session]
    public $vehicleId;

    public function mount()
    {
        $this->vehicleId = session()->get('vehicleId');
    }

    public function render()
    {
        session(['vehicleId' => $this->vehicleId]);
        $vehicle = Vehicle::find($this->vehicleId);
        if ($vehicle && $vehicle->fuelEntries->count()) {
            if (Auth::user()->distance_units == 'mi') {
                $this->stat['avg_efficiency'] = $vehicle->fuelEntries()->avg('mpg');
                $this->stat['last_efficiency'] = $vehicle->fuelEntries()->latest('odometer')->first()?->mpg;
                $this->stat['total_distance'] = $vehicle->fuelEntries()->latest('odometer')->first()?->odometer - $vehicle->initial_odometer;
            } else {
                $this->stat['avg_efficiency'] = $vehicle->fuelEntries()->avg('kpl');
                $this->stat['last_efficiency'] = $vehicle->fuelEntries()->latest('odometer')->first()?->kpl;
                $this->stat['total_distance'] = Number::format(($vehicle->fuelEntries()->latest('odometer')->first()?->odometer - $vehicle->initial_odometer) * 1.60934, 2);
            }
            $this->stat['total_cost'] = $vehicle->fuelEntries()->sum('total_cost');
        } else {
            $this->stat = [];
        }

        return view('dashboard');
    }
}
