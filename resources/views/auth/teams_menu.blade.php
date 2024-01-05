@if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
    <div class="border-t border-gray-200 dark:border-gray-600"></div>

    <div class="block px-4 py-2 text-xs text-gray-400">
        {{ __('Manage Team') }}
    </div>

    <!-- Team Settings -->
    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
        {{ __('Team Settings') }}
    </x-responsive-nav-link>

    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
            {{ __('Create New Team') }}
        </x-responsive-nav-link>
    @endcan

    <!-- Team Switcher -->
    @if (Auth::user()->allTeams()->count() > 1)
        <div class="border-t border-gray-200 dark:border-gray-600"></div>

        <div class="block px-4 py-2 text-xs text-gray-400">
            {{ __('Switch Teams') }}
        </div>

        @foreach (Auth::user()->allTeams() as $team)
            <x-switchable-team :team="$team" component="responsive-nav-link" />
        @endforeach
    @endif
@endif
