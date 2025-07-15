<section class="w-full">
    <h1 class="text-2xl font-bold">Create Fuel Entry</h1>

    <div class="flex flex-col gap-4 mt-4">
        <form wire:submit="create" class="flex flex-col gap-4">
            @include('livewire.fuel-entry-form')
            <flux:button type="submit" variant="primary" class="mt-6">Create Fuel Entry</flux:button>
            <flux:button :href="route('fuel-entries.index')" class="mt-6">Cancel</flux:button>
        </form>
    </div>
</section>
