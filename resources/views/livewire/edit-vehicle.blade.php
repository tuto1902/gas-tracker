<div>
    <h1 class="text-2xl font-bold">Edit Vehicle</h1>

    <div class="flex flex-col gap-4 mt-4">
        <form wire:submit="update" class="flex flex-col gap-4">
            @include('livewire.vehicle-form')
            <flux:button type="submit" class="mt-6">Update Vehicle</flux:button>
        </form>
    </div>
</div>
