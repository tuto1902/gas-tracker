<section class="w-full">
    <h1 class="text-2xl font-bold">Fuel Entries</h1>
    <div class="flex w-full justify-center">
        <flux:select wire:model.live="vehicleId" class="sm:max-w-lg">
            <flux:select.option value="">Choose vehicle...</flux:select.option>
            @foreach(Auth::user()->vehicles as $vehicle)
                <flux:select.option :value="$vehicle->id">
                    {{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }} {{ $vehicle->nickname ? '(' . $vehicle->nickname . ')' : '' }}
                </flux:select.option>
            @endforeach
        </flux:select>
    </div>
    <div class="flex flex-col gap-4 mt-4">
        @foreach ($fuelEntries as $fuelEntry)
            <a href="{{ route('fuel-entries.edit', [$vehicle, $fuelEntry]) }}" aria-label="Fuel Entry">
                <flux:card size="sm" class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                    <flux:text class="flex flex-col items-start gap-4">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex flex-col items-start gap-4">
                            <span class="text-md font-bold text-zinc-400">
                                {{ $fuelEntry->date->format('M d, Y') }}
                            </span>
                                <span class="text-xs text-zinc-400">
                                {{ ceil($fuelEntry->odometer) }} {{ $vehicle->distance_units }} | {{ ceil($fuelEntry->fuelAmountConverted) }} {{ Auth::user()->volumeUnitsLabel }} | {{ Number::currency($fuelEntry->total_cost) }}
                            </span>
                            </div>
                            <span class="text-md font-bold text-zinc-400">
                            {{ Number::format($fuelEntry->fuelEfficiency, 1) }} {{ Auth::user()->distance_units == 'mi' ? 'mpg' : 'kpl' }}
                        </span>
                        </div>
                    </flux:text>
                </flux:card>
            </a>
        @endforeach
    </div>
    @if($vehicleId)
        <div class="flex w-full justify-center mt-4">
            <flux:button :href="route('fuel-entries.create', ['vehicle' => $vehicleId])" variant="primary"
                         class="uppercase w-full sm:max-w-lg">New Fuel Entry
            </flux:button>
        </div>
    @endif
</section>
