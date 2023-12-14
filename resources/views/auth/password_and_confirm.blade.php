                {{-- Clave y confirmación --}}

                <div class="flex-cols-4 texto-azul flex flex-grow justify-between md:flex-cols-4 gap-2">
                    <div class="flex-cols-4 texto-azul flex flex-grow justify-between md:flex-cols-4 gap-2">
                        {{-- Password --}}
                        <div x-data="{ showPassword: false }" class="mt-4 flex items-center">
                            <div>
                                <x-label for="password" value="{{ __('Password') }}" />
                                <div class="flex items-center">
                                    <x-input id="password" x-bind:type="showPassword ? 'text' : 'password'"
                                        name="password" autocomplete="new-password" class="block mt-1 w-full" />

                                    <button x-on:click="showPassword = !showPassword" type="button"
                                        class="ml-2 flex items-center">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Confirmación de Password --}}
                        <div x-data="{ showConfirmPassword: false }" class="mt-4 flex items-center">
                            <div>
                                <x-label for="password" value="{{ __('Confirm Password') }}" />
                                <div class=flex items-center">
                                    <x-input id="password_confirmation"
                                        x-bind:type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation"
                                        autocomplete="new-password" class="block mt-1 w-full" />
                                    <button x-on:click="showConfirmPassword = !showConfirmPassword" type="button"
                                        class="ml-2">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
