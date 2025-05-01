<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm" x-data="{ open: false, userMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="hidden sm:ml-8 sm:flex sm:items-center sm:space-x-4">
                    <x-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150 ease-in-out">
                        <i class="fas fa-user mr-1"></i> {{ __('Profile') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="flex items-center">
                <button @click="darkMode = !darkMode" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mr-4 focus:outline-none">
                    <i class="fas fa-moon text-lg" x-show="!darkMode"></i>
                    <i class="fas fa-sun text-lg" x-show="darkMode"></i>
                </button>

                <div class="relative ml-3" x-data="{ open: false }">
                    <div>
                        <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out" id="user-menu-button">
                            <span class="sr-only">Open user menu</span>
                            <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="h-full w-full object-cover">
                                @else
                                    <i class="fas fa-user text-gray-400 dark:text-gray-500"></i>
                                @endif
                            </div>
                            <div class="hidden md:flex md:items-center ml-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-gray-400 ml-1 text-xs"></i>
                            </div>
                        </button>
                    </div>

                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-800 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                         role="menu" 
                         aria-orientation="vertical" 
                         aria-labelledby="user-menu-button">
                        <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                <i class="fas fa-sign-out-alt w-5 mr-2"></i>
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="flex items-center sm:hidden ml-4">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition duration-150 ease-in-out">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars text-xl" x-show="!open"></i>
                        <i class="fas fa-times text-xl" x-show="open"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show="open" class="sm:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="block pl-3 pr-4 py-2 text-base font-medium border-l-4 transition duration-150 ease-in-out">
                <i class="fas fa-user mr-2"></i> {{ __('Profile') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center px-4"></div>
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-red-300 focus:outline-none transition duration-150 ease-in-out">
                        <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
