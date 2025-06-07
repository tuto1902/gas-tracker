<?php

namespace App\Livewire;

use App\Livewire\FuelEntryForm;
use Livewire\Component;
use App\Models\Vehicle;
use Illuminate\Support\Number;

class CreateFuelEntry extends Component
{
    public FuelEntryForm $form;
    public Vehicle $vehicle;

    public function updated($property)
    {
        // If the fuel amount is changed, update the total cost using the price per unit
        if ($property === 'form.fuel_amount' && $this->form->price_per_unit && $this->form->fuel_amount) {
            $this->form->total_cost = Number::format($this->form->price_per_unit * $this->form->fuel_amount, 2);
        }
        // If the price per unit is changed, update the total cost using the fuel amount
        if ($property === 'form.price_per_unit' && $this->form->price_per_unit > 0) {
            $this->form->total_cost = Number::format($this->form->price_per_unit * $this->form->fuel_amount, 2);
        }
        // If the total cost is changed, update the fuel amount using the price per unit
        if ($property === 'form.total_cost' && $this->form->price_per_unit > 0) {
            $this->form->fuel_amount = Number::format($this->form->total_cost / $this->form->price_per_unit, 2);
        }
    }
    public function render()
    {
        return view('livewire.create-fuel-entry');
    }

    public function create()
    {
        $this->form->setVehicle($this->vehicle);
        $this->form->store();

        $this->redirect(route('fuel-entries.index', ['vehicle' => $this->vehicle->id]));
    }
}
