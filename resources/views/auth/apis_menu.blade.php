@if (Laravel\Jetstream\Jetstream::hasApiFeatures())
    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
        {{ __('API Tokens') }}
    </x-responsive-nav-link>
@endif
