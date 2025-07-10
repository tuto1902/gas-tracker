<div>
    <h1 class="text-2xl font-bold">Edit Fuel Entry</h1>

    <div class="flex flex-col gap-4 mt-4">
        <form wire:submit="update" class="flex flex-col gap-4">
            @include('livewire.fuel-entry-form')
            <flux:button type="submit" class="mt-6">Update Fuel Entry</flux:button>
            <flux:modal.trigger name="delete-fuel-entry">
                <flux:button variant="danger" class="mt-6">Delete Fuel Entry</flux:button>
            </flux:modal.trigger>
        </form>
    </div>
    <flux:modal name="delete-fuel-entry" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete fuel entry?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to delete this fuel entry.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger" wire:click="delete">Delete fuel entry</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
