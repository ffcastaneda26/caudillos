<x-guest-layout>
    <x-authentication-card>

        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>


        <div class="texto-azul grid grid-row grid-cols-1 text-center">
            <p class="font-bold italic">Introducir nombre completo (Nombres y Apellidos)</p>
            <p class="font-extrabold underline italic">Serán verificados con un documento oficial</p>
        </div>


        <div>
            <form method="POST" action="{{ route('register') }}" class="mt-4">
                @csrf
                <div class="texto-azul flex flex-grow justify-between md:flex-cols-2 gap-2">
                    <div>
                        <x-label for="name" value="Nombre(s)" />
                        <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                            :value="old('first_name')" maxlength="50" autofocus autocomplete="name" />
                        @error('first_name')
                            <div class="badge rounded-pill bg-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-label for="name" value="Apellido(s)" />
                        <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                            :value="old('last_name')" maxlength="50" />
                        @error('last_name')
                            <div class="badge rounded-pill bg-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="texto-azul flex flex-grow justify-between md:flex-cols-2 gap-2">
                    <div class="mt-4">
                        <x-label for="email" value="Correo" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" autocomplete="username" />
                        @error('email')
                            <div class="badge rounded-pill bg-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mt-4">
                        <x-label for="phone" value="Teléfono" />
                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                            :value="old('phone')" maxlength="10" minlength="10"  autocomplete="username" />
                        @error('phone')
                            <div class="badge rounded-pill bg-danger">{{ $message }}</div>
                        @enderror

                    </div>

                </div>

                <div class="texto-azul flex flex-grow justify-between md:flex-cols-2 gap-2">
                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                            autocomplete="new-password" />
                        @error('password')
                            <div class="badge rounded-pill bg-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" autocomplete="new-password" />
                        @error('password_confirmation')
                            <div class="badge rounded-pill bg-danger  mt-1 w-full">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- Aceptar ser mayor de edad --}}
                <div class=" row align-items-start">
                    <div class="mt-4">
                        <x-label for="adult">
                            <div class="flex items-center">
                                <x-checkbox name="adult" id="adult"  />
                                <div class="ml-2">
                                    <label for=""
                                        class="underline text-sm texto-oro dark:text-gray-400 hover:text-red-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800">
                                        ACEPTO SER MAYOR DE EDAD
                                    </label>
                                </div>
                        </x-label>
                    </div>
                    @error('adult')
                        <div class="badge rounded-pill bg-danger">{{ $message }}</div>
                    @enderror
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="texto-azul mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms"  />

                                <div class="texto-azul ml-2">
                                    Acepto los <a target="_blank" href="{{ route('terms.show') }} "
                                        class="underline text-sm dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                        {{ __('Terms of Service') }}
                                    </a>
                                </div>
                                @error('terms')
                                    <div class="badge rounded-pill bg-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </x-label>
                    </div>
                @endif
                <div class="flex justify-between items-center mt-4">

                    <a href="{{ route('login') }}" class="inline rounded-xl btn btn-sm fondo-azul texto-oro font-semibold  hover:text-white">
                        {{ __('Already registered?') }}
                    </a>

                    <x-register />
                </div>
            </form>
        </div>



    </x-authentication-card>


</x-guest-layout>
