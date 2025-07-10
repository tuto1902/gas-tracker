<?php

namespace App\Livewire;

use App\Models\FuelEntry;
use App\Models\Vehicle;
use Livewire\Component;
use App\Livewire\FuelEntryForm;
use Illuminate\Support\Number;

class EditFuelEntry extends Component
{
    public FuelEntryForm $form;
    public Vehicle $vehicle;

    public function mount(Vehicle $vehicle, FuelEntry $fuelEntry)
    {
        $this->vehicle = $vehicle;
        $this->form->setVehicle($vehicle);
        $this->form->setFuelEntry($fuelEntry);
    }

    public function update()
    {
        $this->form->update();

        $this->redirect(route('fuel-entries.index', $this->vehicle));
    }

    public function delete()
    {
        $this->form->delete();

        $this->redirect(route('fuel-entries.index', $this->vehicle));
    }

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
        return view('livewire.edit-fuel-entry');
    }
}
