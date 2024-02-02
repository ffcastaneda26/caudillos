<div class="dropdown d-inline-block">
    <button type="button"
    class="btn header-item waves-effect"
    id="page-header-user-dropdown"
    data-bs-toggle="dropdown"
    aria-haspopup="true"
    aria-expanded="false">
        @auth
            @if (Auth::user()->profile_photo_path)
                <img width="32" height="32" class="rounded-circle object-cover" src="/storage/{{Auth::user()->profile_photo_path }}" alt="{{ Auth::user()->name }}" />
            @else
                <img width="32" height="32" class="rounded-circle object-cover" src="{{Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
            @endif
        @endauth
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <!-- item-->
        @auth
            <a class="dropdown-item" href="{{ route('profile.show') }}"> {{ __('Profile') }}</a>
        @endauth

        <div class="dropdown-divider"></div>

        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-jet-dropdown-link href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-jet-dropdown-link>
        </form>
    </div>
</div>
