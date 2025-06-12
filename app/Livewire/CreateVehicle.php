<?php

namespace App\Livewire;

use App\Livewire\VehicleForm;
use App\Models\Vehicle;
use Livewire\Attributes\Url;
use Livewire\Component;

class CreateVehicle extends Component
{
    public VehicleForm $form;

    public ?Vehicle $vehicle = null;

    public function render()
    {
        return view('livewire.create-vehicle');
    }

    public function create()
    {
        $this->form->store();

        $this->redirect(route('vehicles.index'));
    }
}
