<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <x-filament::button class="mt-4" type="submit">
            Modifier
        </x-filament::button>
    </form>
    <x-filament-actions::modals />
</x-filament-panels::page>
