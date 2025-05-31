    <flux:field>
        <flux:label>Make</flux:label>
        <flux:input wire:model="form.make" type="text" />
        <flux:error name="form.make" />
    </flux:field>

    <flux:field>
        <flux:label>Model</flux:label>
        <flux:input wire:model="form.model" type="text" />
        <flux:error name="form.model" />
    </flux:field>

    <flux:field>
        <flux:label>Year</flux:label>
        <flux:input wire:model="form.year" type="number" />
        <flux:error name="form.year" />
    </flux:field>

    <flux:field>
        <flux:label>Nickname (Optional)</flux:label>
        <flux:input wire:model="form.nickname" type="text" />
        <flux:error name="form.nickname" />
    </flux:field>


    <flux:field>
        <flux:label>Initial Odometer Reading</flux:label>
        <flux:input wire:model="form.initial_odometer" type="number" />
        <flux:error name="form.initial_odometer" />
    </flux:field>

    <flux:radio.group wire:model="form.distance_units" label="Distance Units" variant="segmented">
        <flux:radio label="Miles" value="miles" />
        <flux:radio label="Kilometers" value="km" />
    </flux:radio.group>
