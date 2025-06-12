<flux:field>
    <flux:label>Date</flux:label>
    <flux:date-picker wire:model="form.date" />
    <flux:error name="form.date" />
</flux:field>

<flux:field>
    <flux:label>Odometer</flux:label>
    <flux:input.group>
        <flux:input wire:model="form.odometer" type="text" />
        <flux:input.group.suffix>{{ $vehicle->distanceUnitsLabel }}</flux:input.group.suffix>
    </flux:input.group>
    <flux:error name="form.odometer" />
</flux:field>

<flux:field>
    <flux:label>Fuel Amount</flux:label>
    <flux:input.group>
        <flux:input wire:model.blur="form.fuel_amount" type="text" />
        <flux:input.group.suffix>{{ Auth::user()->volumeUnitsLabel }}</flux:input.group.suffix>
    </flux:input.group>
    <flux:error name="form.fuel_amount" />
</flux:field>

<flux:field>
    <flux:label>Price per Unit</flux:label>
    <flux:input wire:model.blur="form.price_per_unit" type="text" />
    <flux:error name="form.price_per_unit" />
</flux:field>

<flux:field>
    <flux:label>Total Cost</flux:label>
    <flux:input wire:model.blur="form.total_cost" type="text" />
    <flux:error name="form.total_cost" />
</flux:field>
