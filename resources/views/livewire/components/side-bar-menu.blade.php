<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-7">
        <li>
            <ul role="list" class="-mx-2 space-y-1">
                <li>
                    <x-side-bar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-side-bar-link>
                </li>
                <li>
                    <x-side-bar-link href="{{ route('dashboard.links.index') }}" :active="request()->routeIs('dashboard.links.index')">
                        {{ __('Links') }}
                    </x-side-bar-link>
                </li>
            </ul>
        </li>

        <li class="mt-auto">
            <x-side-bar-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                {{ __('Settings') }}
            </x-side-bar-link>
        </li>
    </ul>
</nav>
