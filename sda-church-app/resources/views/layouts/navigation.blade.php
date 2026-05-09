<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 border-b-2 border-b-primary-500">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="h-10 w-auto block text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    @if(!in_array(Auth::user()->role, ['Treasurer', 'Funds Controller', 'Member']))
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')">
                            {{ __('Members') }}
                        </x-nav-link>
                        <x-nav-link :href="route('departments.index')" :active="request()->routeIs('departments.*')">
                            {{ __('Departments') }}
                        </x-nav-link>
                    @elseif(Auth::user()->role === 'Member')
                        @php $navAnnouncementCount = \App\Models\Announcement::active()->count(); @endphp
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <a href="{{ route('member.announcements') }}"
                           class="{{ request()->routeIs('member.announcements') ? 'border-primary-500 text-gray-900' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300' }} inline-flex items-center gap-1.5 px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out">
                            {{ __('Announcements') }}
                            @if($navAnnouncementCount > 0)
                                <span class="inline-flex items-center justify-center min-w-[1.1rem] h-[1.1rem] px-1 text-[10px] font-bold bg-primary-600 text-white rounded-full leading-none">
                                    {{ $navAnnouncementCount }}
                                </span>
                            @endif
                        </a>
                    @endif
                    @if(Auth::user()->role === 'Super Admin')
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out cursor-pointer mt-[6px]">
                                        <div>{{ __('Finance') }}</div>
                                        <div class="ms-1">
                                            <svg aria-hidden="true" class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('finance.index')">
                                        {{ __('Treasurer') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('funds-controller.classes')">
                                        {{ __('Funds Controller - Classes') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('funds-controller.departments')">
                                        {{ __('Funds Controller - Departments') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @elseif(Auth::user()->role === 'Treasurer')
                        <x-nav-link :href="route('finance.index')" :active="request()->routeIs('finance.*')">
                            {{ __('Finance') }}
                        </x-nav-link>
                    @elseif(Auth::user()->role === 'Funds Controller')
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out cursor-pointer mt-[6px]">
                                        <div>{{ __('Funds Controller') }}</div>
                                        <div class="ms-1">
                                            <svg aria-hidden="true" class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('funds-controller.classes')">
                                        {{ __('Classes') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('funds-controller.departments')">
                                        {{ __('Departments') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                    @if(!in_array(Auth::user()->role, ['Treasurer', 'Funds Controller', 'Member']))
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out cursor-pointer mt-[6px]"
                                            :class="{ 'border-primary-400 text-primary-700': request()->routeIs('documents.*') || request()->routeIs('baptisms.*') || request()->routeIs('announcements.*') || request()->routeIs('transfers.*') }">
                                        <div>{{ __('Records') }}</div>
                                        <div class="ms-1">
                                            <svg aria-hidden="true" class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('documents.index')" :active="request()->routeIs('documents.*')">
                                        {{ __('Documents') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('baptisms.index')" :active="request()->routeIs('baptisms.*')">
                                        {{ __('Baptisms') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('announcements.index')" :active="request()->routeIs('announcements.*')">
                                        {{ __('Announcements') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('transfers.index')" :active="request()->routeIs('transfers.*')">
                                        {{ __('Transfers') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        @php
                            $firstName = Auth::user()->first_name ?? '';
                            $lastName  = Auth::user()->last_name ?? '';
                            $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                            $role      = Auth::user()->role ?? 'User';

                            // Pick a deterministic avatar colour from the user's name
                            $colours = [
                                'bg-indigo-600', 'bg-violet-600', 'bg-blue-600',
                                'bg-emerald-600', 'bg-teal-600', 'bg-rose-600',
                            ];
                            $colourClass = $colours[abs(crc32($firstName . $lastName)) % count($colours)];
                        @endphp

                        <button aria-label="Open user menu" class="inline-flex items-center gap-2.5 px-2.5 py-1.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 hover:border-primary-300 shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-1">
                            {{-- Avatar --}}
                            <div class="w-8 h-8 rounded-full {{ $colourClass }} flex items-center justify-center text-white text-xs font-bold flex-shrink-0" aria-hidden="true">
                                {{ $initials }}
                            </div>
                            {{-- Name only --}}
                            <div class="text-left hidden lg:block">
                                <div class="text-sm font-semibold text-gray-800 leading-tight">
                                    {{ $firstName }} {{ $lastName }}
                                </div>
                            </div>

                            {{-- Chevron --}}
                            <svg aria-hidden="true" class="fill-current h-3.5 w-3.5 text-gray-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- Profile header inside dropdown --}}
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-800 truncate">{{ $firstName }} {{ $lastName }}</div>
                                <div class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</div>
                            </div>
                            <span class="mt-2 inline-block px-2 py-0.5 text-xs font-bold rounded-full
                                @if($role === 'Super Admin') bg-primary-100 text-primary-700
                                @elseif($role === 'Treasurer') bg-emerald-100 text-emerald-700
                                @elseif($role === 'Funds Controller') bg-amber-100 text-amber-700
                                @elseif($role === 'Member') bg-gray-100 text-gray-600
                                @else bg-neutral-100 text-neutral-700
                                @endif">
                                {{ $role }}
                            </span>
                        </div>

                        {{-- Menu items --}}
                        <div class="py-1">
                            <x-dropdown-link :href="route('profile.edit')">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ __('My Profile') }}
                                </div>
                            </x-dropdown-link>
                        </div>

                        <div class="border-t border-gray-100 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    <div class="flex items-center gap-2 text-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        {{ __('Log Out') }}
                                    </div>
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" :aria-expanded="open.toString()" aria-label="Toggle navigation menu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(!in_array(Auth::user()->role, ['Treasurer', 'Funds Controller', 'Member']))
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')">
                    {{ __('Members') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('departments.index')" :active="request()->routeIs('departments.*')">
                    {{ __('Departments') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->role === 'Member')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('member.announcements')" :active="request()->routeIs('member.announcements')">
                    {{ __('Announcements') }}
                    @if(isset($navAnnouncementCount) && $navAnnouncementCount > 0)
                        <span class="ml-1 inline-flex items-center justify-center min-w-[1.1rem] h-[1.1rem] px-1 text-[10px] font-bold bg-primary-600 text-white rounded-full leading-none">
                            {{ $navAnnouncementCount }}
                        </span>
                    @endif
                </x-responsive-nav-link>
            @endif
            @if(Auth::user()->role === 'Super Admin')
                <div class="px-4 py-2 text-xs font-semibold tracking-wide text-gray-500 uppercase">{{ __('Finance') }}</div>
                <x-responsive-nav-link :href="route('finance.index')" :active="request()->routeIs('finance.*')">
                    {{ __('Treasurer') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('funds-controller.classes')">
                    {{ __('Funds Controller - Classes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('funds-controller.departments')">
                    {{ __('Funds Controller - Departments') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->role === 'Treasurer')
                <x-responsive-nav-link :href="route('finance.index')" :active="request()->routeIs('finance.*')">
                    {{ __('Finance') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->role === 'Funds Controller')
                <div class="px-4 py-2 text-xs font-semibold tracking-wide text-gray-500 uppercase">{{ __('Funds Controller') }}</div>
                <x-responsive-nav-link :href="route('funds-controller.classes')">
                    {{ __('Classes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('funds-controller.departments')">
                    {{ __('Departments') }}
                </x-responsive-nav-link>
            @endif
            @if(!in_array(Auth::user()->role, ['Treasurer', 'Funds Controller', 'Member']))
                <div class="px-4 py-2 text-xs font-semibold tracking-wide text-gray-500 uppercase">{{ __('Records') }}</div>
                <x-responsive-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.*')">
                    {{ __('Documents') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('baptisms.index')" :active="request()->routeIs('baptisms.*')">
                    {{ __('Baptisms') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('announcements.index')" :active="request()->routeIs('announcements.*')">
                    {{ __('Announcements') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('transfers.index')" :active="request()->routeIs('transfers.*')">
                    {{ __('Transfers') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center gap-3">
                <div>
                    <div class="font-semibold text-sm text-gray-800">{{ $firstName }} {{ $lastName }}</div>
                    <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
                    <span class="mt-1 inline-block px-2 py-0.5 text-xs font-bold rounded-full
                        @if($role === 'Super Admin') bg-primary-100 text-primary-700
                        @elseif($role === 'Treasurer') bg-emerald-100 text-emerald-700
                        @elseif($role === 'Funds Controller') bg-amber-100 text-amber-700
                        @elseif($role === 'Member') bg-neutral-100 text-neutral-600
                        @else bg-violet-100 text-violet-700
                        @endif">
                        {{ $role }}
                    </span>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('My Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
