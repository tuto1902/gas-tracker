<section class="w-full">
    <h1 class="text-2xl font-bold">Create Vehicle</h1>

    <div class="flex flex-col gap-4 mt-4">
        <form wire:submit="create" class="flex flex-col gap-4">
            @include('livewire.vehicle-form')
            <flux:button type="submit" class="mt-6">Create Vehicle</flux:button>
        </form>
    </div>
</section>
