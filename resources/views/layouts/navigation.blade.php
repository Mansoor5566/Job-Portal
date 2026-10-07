<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                    💼 JobPortal
                </a>
                {{-- Nav Links --}}
                <div class="hidden sm:flex sm:items-center sm:ml-8 gap-6 text-sm">
                    <a href="{{ route('jobs.index') }}"
                       class="text-gray-600 hover:text-indigo-600 {{ request()->routeIs('jobs.*') ? 'text-indigo-600 font-semibold' : '' }}">
                        Browse Jobs
                    </a>
                    @auth
                        @if(auth()->user()->isEmployer())
                            <a href="{{ route('employer.jobs.index') }}"
                               class="text-gray-600 hover:text-indigo-600 {{ request()->routeIs('employer.jobs.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                My Jobs
                            </a>
                            <a href="{{ route('employer.applications.index') }}"
                               class="text-gray-600 hover:text-indigo-600 {{ request()->routeIs('employer.applications.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                Applications
                            </a>
                        @endif
                        @if(auth()->user()->isSeeker())
                            <a href="{{ route('seeker.applications') }}"
                               class="text-gray-600 hover:text-indigo-600 {{ request()->routeIs('seeker.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                My Applications
                            </a>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="text-gray-600 hover:text-indigo-600">
                                Admin Panel
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Right Side --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-4">
                @auth
                    {{-- Role Badge --}}
                    <span class="text-xs px-2 py-1 rounded-full
                        {{ auth()->user()->isAdmin() ? 'bg-red-100 text-red-700' :
                           (auth()->user()->isEmployer() ? 'bg-green-100 text-green-700' :
                           'bg-blue-100 text-blue-700') }}">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-800">
                                {{ auth()->user()->name }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('dashboard') }}">Dashboard</x-dropdown-link>
                            <x-dropdown-link href="{{ route('profile.edit') }}">Profile</x-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-600 hover:text-indigo-600">Login</a>
                    <a href="{{ route('register') }}"
                       class="text-sm bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Register
                    </a>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" class="sm:hidden px-4 pb-4 space-y-2 text-sm">
        <a href="{{ route('jobs.index') }}" class="block text-gray-600 hover:text-indigo-600 py-2">Browse Jobs</a>
        @auth
            <a href="{{ route('dashboard') }}" class="block text-gray-600 hover:text-indigo-600 py-2">Dashboard</a>
            @if(auth()->user()->isSeeker())
                <a href="{{ route('seeker.applications') }}" class="block text-gray-600 py-2">My Applications</a>
            @endif
            @if(auth()->user()->isEmployer())
                <a href="{{ route('employer.jobs.index') }}" class="block text-gray-600 py-2">My Jobs</a>
                <a href="{{ route('employer.applications.index') }}" class="block text-gray-600 py-2">Applications</a>
            @endif
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block text-gray-600 py-2">Admin Panel</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block text-red-500 py-2">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block text-gray-600 py-2">Login</a>
            <a href="{{ route('register') }}" class="block text-gray-600 py-2">Register</a>
        @endauth
    </div>
</nav>