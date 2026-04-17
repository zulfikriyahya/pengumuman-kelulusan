{{-- <x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}
            {{ $this->registerAction }}
        </x-slot>
    @endif
    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}
        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>
    <x-auth-wrapper />
</x-filament-panels::page.simple> --}}
<x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            Belum punya akun?
            {{ $this->registerAction }}
        </x-slot>
    @endif

    <form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament::button type="submit" class="w-full">
            Masuk
        </x-filament::button>
    </form>

    <x-auth-wrapper />
</x-filament-panels::page.simple>
