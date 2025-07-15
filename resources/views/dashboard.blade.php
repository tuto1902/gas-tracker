<div class="flex w-full h-full flex-1 flex-col gap-4 rounded-xl">
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
    @if($stat)
        <div class="flex gap-6 flex-col sm:flex-row">
            <div class="px-6 py-4 rounded-lg border border-neutral-200 flex-1 dark:border-neutral-700">
                <flux:text size="sm" class="mb-2">AVG. EFFICIENCY</flux:text>
                <flux:heading size="xl">{{ $stat['avg_efficiency'] }}</flux:heading>
                <flux:text size="sm">{{ Auth::user()->distance_units == 'mi' ? 'MPG' : 'KPL' }}</flux:text>
            </div>
            <div class="px-6 py-4 rounded-lg border border-neutral-200 flex-1 dark:border-neutral-700">
                <flux:text size="sm" class="mb-2">LAST EFFICIENCY</flux:text>
                <flux:heading size="xl">{{ $stat['last_efficiency'] }}</flux:heading>
                <flux:text size="sm">{{ Auth::user()->distance_units == 'mi' ? 'MPG' : 'KPL' }}</flux:text>
            </div>
            <div class="px-6 py-4 rounded-lg border border-neutral-200 flex-1 dark:border-neutral-700">
                <flux:text size="sm" class="mb-2">TOTAL DISTANCE</flux:text>
                <flux:heading size="xl">{{ $stat['total_distance'] }}</flux:heading>
                <flux:text size="sm">{{ strtoupper(Auth::user()->distance_units) }}</flux:text>
            </div>
            <div class="px-6 py-4 rounded-lg border border-neutral-200 flex-1 dark:border-neutral-700">
                <flux:text size="sm" class="mb-2">TOTAL COST</flux:text>
                <flux:heading size="xl">{{ Number::currency($stat['total_cost']) }}</flux:heading>
                <flux:text size="sm">USD</flux:text>
            </div>
            <div class="px-6 py-4 rounded-lg border border-neutral-200 flex-1 dark:border-neutral-700">
                <flux:text size="sm" class="mb-2">COST / {{ strtoupper(Auth::user()->distance_units) }}</flux:text>
                <flux:heading
                    size="xl">{{ Number::format($stat['total_cost'] / $stat['total_distance'], 2) }}</flux:heading>
                <flux:text size="sm">USD</flux:text>
            </div>
        </div>
        <div class="flex w-full justify-center">
            <flux:button :href="route('fuel-entries.create', ['vehicle' => $vehicleId])" variant="primary"
                         class="uppercase w-full sm:max-w-lg">New Fuel Entry
            </flux:button>
        </div>
    @endif
</div>
