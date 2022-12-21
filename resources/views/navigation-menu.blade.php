<nav x-data="{ open: false }" class="sticky top-0 bg-white border-b border-gray-100 z-99">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 w-full">
            <div class="flex justify-between w-full">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                    @if (Route::has('login'))
                    @auth
                    <a href="/">
                        <img src="../../../img/shopculator-title.svg" alt="Shopculator" width="175" />
                    </a>
                    @else
                    <a href="/">
                        <img src="img/shopculator-title.svg" alt="Shopculator" width="175" />
                    </a>
                    @endauth
                    @endif
                </div>

                @if (Route::has('login'))
                @auth
                @if (Auth::user()->role_id == 'R1')
                <!-- Navigation Links for Admin -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 md:flex">
                    <x-jet-nav-link href="{{ route('admin/users') }}" :active="request()->routeIs('admin/users')">
                        <b>{{ __('Users') }}</b>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('admin/markets') }}" :active="request()->routeIs('admin/markets')">
                        <b>{{ __('Markets') }}</b>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('admin/categories') }}" :active="request()->routeIs('admin/categories')">
                        <b>{{ __('Categories') }}</b>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('admin/subcategories') }}" :active="request()->routeIs('admin/subcategories')">
                        <b>{{ __('Subcategories') }}</b>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('admin') }}" :active="request()->routeIs('admin')">
                        <b>{{ __('Stats') }}</b>
                    </x-jet-nav-link>
                </div>
                @endif
                @if (Auth::user()->role_id == 'R2')
                <!-- Navigation Links for Markets -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 md:flex">
                    <x-jet-nav-link href="{{ route('market') }}" :active="request()->routeIs('market')">
                        <b>{{ __('Products') }}</b>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('market/stats') }}" :active="request()->routeIs('market/stats')">
                        <b>{{ __('Stats') }}</b>
                    </x-jet-nav-link>
                </div>
                @endif
                @if (Auth::user()->role_id == 'R3')
                <!-- Navigation Links for Shoppers -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 md:flex">
                    <x-jet-nav-link href="{{ route('shopper/stats') }}" :active="request()->routeIs('shopper/stats')">
                        <b>{{ __('Stats') }}</b>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('shopper') }}" :active="request()->routeIs('shopper')">
                        <b>{{ __('Your Lists') }}</b>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('shopper/create') }}" :active="request()->routeIs('shopper/create')">
                        <b>{{ __('New List') }}</b>
                    </x-jet-nav-link>
                </div>
                @endif
                @endauth
                @endif
            </div>

            @if (Route::has('login'))
            @auth
            <div class="hidden md:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                    {{ Auth::user()->currentTeam->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-60">
                                <!-- Team Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Team') }}
                                </div>

                                <!-- Team Settings -->
                                <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                    {{ __('Team Settings') }}
                                </x-jet-dropdown-link>

                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Create New Team') }}
                                </x-jet-dropdown-link>
                                @endcan

                                <div class="border-t border-gray-100"></div>

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Switch Teams') }}
                                </div>

                                @foreach (Auth::user()->allTeams() as $team)
                                <x-jet-switchable-team :team="$team" />
                                @endforeach
                            </div>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                            @else
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-teal-500 bg-white hover:text-teal-400 focus:outline-none transition">
                                    <b>{{ Auth::user()->name }}</b>

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                {{ __('API Tokens') }}
                            </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>
            @else
            <div class="flex justify-end w-1/4">
                <div class="flex px-4 items-center space-x-2">
                    <button class="sc-btn-ghost">
                        <a class="px-6 py-1.5" href="{{ route('login') }}">Log in</a>
                    </button>
                    <button class="sc-btn-action">
                        <a href="{{ route('register') }}">Sign up</a>
                    </button>
                </div>
            </div>
            @endauth
            @endif

            <!-- Hamburger -->
            <div class="-mr-2 md:hidden flex items-center">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">

        </div>
        @if (Route::has('login'))
        @auth
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="shrink-0 mr-3">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-jet-responsive-nav-link href="{{ route('shopper') }}" :active="request()->routeIs('shopper')">
                    {{ __('Your Lists') }}
                </x-jet-responsive-nav-link>
                <hr />
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                    {{ __('API Tokens') }}
                </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="border-t border-gray-200"></div>

                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Manage Team') }}
                </div>

                <!-- Team Settings -->
                <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                    {{ __('Team Settings') }}
                </x-jet-responsive-nav-link>

                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                    {{ __('Create New Team') }}
                </x-jet-responsive-nav-link>
                @endcan

                <div class="border-t border-gray-200"></div>

                <!-- Team Switcher -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Switch Teams') }}
                </div>

                @foreach (Auth::user()->allTeams() as $team)
                <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                @endforeach
                @endif
            </div>
        </div>
        @endauth
        @endif
    </div>
</nav>