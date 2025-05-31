<div>
    <h1 class="text-2xl font-bold">Edit Vehicle</h1>

    <div class="flex flex-col gap-4 mt-4">
        <form wire:submit="update" class="flex flex-col gap-4">
            @include('livewire.vehicle-form')
            <flux:button type="submit" class="mt-6">Update Vehicle</flux:button>
            <flux:modal.trigger name="delete-vehicle">
                <flux:button variant="danger" class="mt-6">Delete Vehicle</flux:button>
            </flux:modal.trigger>
        </form>
    </div>
    <flux:modal name="delete-vehicle" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete vehicle?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to delete this vehicle.</p>
                    <p>This will delete all fuel entries for this vehicle.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger" wire:click="delete">Delete vehicle</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
