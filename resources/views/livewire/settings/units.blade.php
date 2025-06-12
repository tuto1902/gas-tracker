<?php

use Livewire\Volt\Component;

new class extends Component {
    public $distanceUnits = 'mi';
    public $volumeUnits = 'gal';

    public function updated($property)
    {
        $this->updateUnits();
    }

    public function updateUnits()
    {
        Auth::user()->update([
            'distance_units' => $this->distanceUnits,
            'volume_units' => $this->volumeUnits,
        ]);
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Units')" :subheading="__('Update your account\'s units settings')">
        <div class="flex flex-col gap-4">
            <flux:radio.group wire:model.live="distanceUnits" label="Distance" variant="segmented">
                <flux:radio value="mi" checked>{{ __('Miles') }}</flux:radio>
                <flux:radio value="km">{{ __('Kilometers') }}</flux:radio>
            </flux:radio.group>

            <flux:radio.group wire:model.live="volumeUnits" label="Volume" variant="segmented">
                <flux:radio value="gal" checked>{{ __('Gallons') }}</flux:radio>
                <flux:radio value="l">{{ __('Liters') }}</flux:radio>
            </flux:radio.group>
        </div>
    </x-settings.layout>
</section>
