<?php

namespace App\Livewire;

use App\Livewire\VehicleForm;
use App\Models\Vehicle;
use Livewire\Component;

class EditVehicle extends Component
{
    public VehicleForm $form;

    public function mount(Vehicle $vehicle)
    {
        $this->form->setVehicle($vehicle);
    }

    public function update()
    {
        $this->form->update();

        $this->redirect(route('vehicles.index'));
    }

    public function render()
    {
        return view('livewire.edit-vehicle');
    }
}
