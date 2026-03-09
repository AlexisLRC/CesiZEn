<nav x-data="{ open: false }" class="bg-cesi-green border-b border-green-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <div class="bg-white rounded-lg flex items-center justify-center shadow-md p-1" style="width: 60px; height: 60px;">
                            <img src="{{ asset('logo.png') }}" style="max-width: 100%; max-height: 100%; object-fit: contain;" alt="Logo CesiZen" />
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-xl font-bold leading-5 transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'border-white text-white' : 'border-transparent text-green-100 hover:text-white hover:border-gray-300' }}">
                            {{ __('Tableau de bord') }}
                        </a>
                        <a href="{{ route('informations') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-xl font-bold leading-5 transition duration-150 ease-in-out {{ request()->routeIs('informations') ? 'border-white text-white' : 'border-transparent text-green-100 hover:text-white hover:border-gray-300' }}">
                            {{ __('Blog / Info') }}
                        </a>
                        @if(Auth::user()->role === 'admin')
                            <div class="hidden sm:flex sm:items-center sm:ms-6">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-1 pt-1 border-b-2 text-lg font-bold leading-5 transition duration-150 ease-in-out border-transparent text-green-100 hover:text-white hover:border-gray-300 ml-6">
                                            <div>Administration</div>
                                            <div class="ms-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('admin.exercises.index')">
                                            Gérer les Exercices
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('admin.pages.index')">
                                            Gérer les Pages d'Info
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('public.exercises') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-xl font-bold leading-5 transition duration-150 ease-in-out border-transparent text-green-100 hover:text-white hover:border-gray-300">
                            Exercices
                        </a>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-cesi-green bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                <div class="mr-3">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-cesi-green">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-cesi-green font-bold border border-cesi-green">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div>{{ Auth::user()->name }}</div>
                                
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Se déconnecter') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-white font-bold hover:text-cesi-yellow transition">Connexion</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-white text-cesi-green font-bold rounded-lg hover:bg-gray-100 transition shadow-md">Créer un compte</a>
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-200 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-green-700">
        @auth
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                    {{ __('Tableau de bord') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('informations')" :active="request()->routeIs('informations')" class="text-white">
                    {{ __('Blog / Info') }}
                </x-responsive-nav-link>
            @if(Auth::user()->role === 'admin')
                <div class="border-t border-green-600 mt-2 pt-2">
                    <div class="px-4 py-2 text-xs font-semibold text-green-200 uppercase tracking-widest">
                        Administration
                    </div>
                    <x-responsive-nav-link :href="route('admin.exercises.index')" :active="request()->routeIs('admin.exercises.*')" class="text-white">
                        Gérer les Exercices
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')" class="text-white">
                        Gérer les Pages d'Info
                    </x-responsive-nav-link>
                </div>
            @endif
            </div>
            <div class="pt-4 pb-1 border-t border-green-600">
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-green-200">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-green-100">{{ __('Profil') }}</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();" class="text-green-100">
                            {{ __('Se déconnecter') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('public.exercises')" class="text-white">Exercices</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('login')" class="text-white">Connexion</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" class="text-white font-bold">Créer un compte</x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>