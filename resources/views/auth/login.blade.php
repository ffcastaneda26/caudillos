<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf


            <div>
                <x-label class="texto-azul" for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    autofocus autocomplete="username" />
            </div>

            @include('auth.login_button')

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" checked/ class="invisible">
                </label>
            </div>


            <div class="flex flex-col">
                {{-- href="{{ route('password.request') }}" --}}
                @if (Route::has('password.request'))
                    <div class="text-right">
                        <a class="underline texto-oro text-xs font-semibold dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                            href="#">
                            {{ __('Forgot your password?') }}
                        </a>
                    </div>
                @endif

                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('register') }}"
                        class="inline rounded-xl btn btn-sm fondo-secundario texto-azul font-semibold  hover:text-white">
                        {{ __('Register') }}
                    </a>

                    <x-login />
                </div>

            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
