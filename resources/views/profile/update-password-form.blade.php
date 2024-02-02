<x-form-section submit="updatePassword">
    <div class="card">
        <x-slot name="title"></x-slot>

        <x-slot name="description"></x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <div class="row">
                    <h1 class="text-center font-bold text-sm">{{ __('Update Password') }}</h1>
                    <h2 class="text-center font-bold text-xs">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}</h2>
                </div>
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="current_password" value="{{ __('Current Password') }}" />
                <x-input id="current_password" type="password" class="mt-1 block w-full"
                    wire:model.defer="state.current_password" autocomplete="current-password" />
                <x-input-error for="current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="password" value="{{ __('New Password') }}" />
                <x-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password"
                    autocomplete="new-password" />
                <x-input-error for="password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" type="password" class="mt-1 block w-full"
                    wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                <x-input-error for="password_confirmation" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </div>

</x-form-section>
