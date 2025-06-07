<section class="w-full">
    <h1 class="text-2xl font-bold">Fuel Entries</h1>
    <h2 class="text-md font-medium">
       {{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }} {{ $vehicle->nickname ? '(' . $vehicle->nickname . ')' : '' }}
    </h2>
    <div class="flex flex-col gap-2 mt-4">
        @foreach ($fuelEntries as $fuelEntry)
        <a href="{{ route('fuel-entries.edit', [$vehicle, $fuelEntry]) }}" aria-label="Fuel Entry">
            <flux:card size="sm" class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                <flux:text class="flex flex-col items-start gap-2">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex flex-col items-start gap-2">
                            <span class="text-md font-bold text-zinc-400">
                                {{ $fuelEntry->date->format('M d, Y') }}
                            </span>
                            <span class="text-xs text-zinc-400">
                                {{ $fuelEntry->odometer }} {{ $vehicle->distance_units }} | {{ $fuelEntry->fuel_amount }} {{ $vehicle->distance_units == 'miles' ? 'gal' : 'l' }} | {{ Number::currency($fuelEntry->total_cost) }}
                            </span>
                        </div>
                        <span class="text-md font-bold text-zinc-400">
                            {{ Number::format($fuelEntry->mpg_kpl, 1) }} {{ $vehicle->distance_units == 'miles' ? 'mpg' : 'kpl' }}
                        </span>
                    </div>
                </flux:text>
            </flux:card>
        </a>
    @endforeach
    </div>
</section>
