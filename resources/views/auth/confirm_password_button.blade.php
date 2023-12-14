{{-- Confirmación de Password --}}
<div x-data="{ showConfirmPassword: false }" class="mt-4 flex items-center">
    <div>
        <x-label for="password" value="{{ __('Confirm Password') }}" />
        <div class="flex items-center">
            <x-input id="password_confirmation"
                x-bind:type="showConfirmPassword ? 'text' : 'password'" name="password"
                autocomplete="new-password" class="block mt-1 w-full" />
            <button x-on:click="showConfirmPassword = !showConfirmPassword" type="button"
                class="ml-2">
                <i class="fa-solid fa-eye"></i>
            </button>
        </div>
        @error('password_confirmation')
            <div class="badge rounded-pill bg-danger">{{ $message }}</div>
        @enderror

    </div>

</div>
