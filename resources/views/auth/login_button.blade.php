<div class="mt-4">
    <div x-data="{ showPassword: false }" class="mt-4 flex items-center">
        <div>
            <x-label for="password" value="{{ __('Password') }}" />
            <div class="flex items-center">
                <x-input id="password"
                        x-bind:type="showPassword ? 'text' : 'password'"
                        name="password"
                        class="block mt-1 w-full" />

                <button x-on:click="showPassword = !showPassword" type="button"
                    class="ml-2 flex items-center">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
        </div>
    </div>
</div>
