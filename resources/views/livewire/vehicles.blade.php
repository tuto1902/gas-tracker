<section class="w-full">
    <h1 class="text-2xl font-bold">Vehicles</h1>
    <div class="flex flex-col gap-2 mt-4">
        @foreach ($vehicles as $vehicle)
        <a href="{{ route('vehicles.edit', $vehicle) }}" aria-label="Vehicle">
            <flux:card size="sm" class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                <flux:heading class="flex items-center gap-2">
                    {{ $vehicle->make }} {{ $vehicle->model }} {{ $vehicle->nickname ? '(' . $vehicle->nickname . ')' : '' }}
                </flux:heading>
                <flux:text class="mt-2 flex flex-col items-start gap-2">
                    <span class="text-xs text-zinc-400">
                        {{ $vehicle->year }}
                    </span>
                    <flux:badge variant="outline" size="sm" class="bg-zinc-100 dark:bg-zinc-800">
                        {{ $vehicle->initial_odometer }} {{ $vehicle->distance_units }}
                    </flux:badge>
                </flux:text>
            </flux:card>
        </a>
    @endforeach
    </div>
</section>
