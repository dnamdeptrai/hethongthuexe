<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 gap-2">
            
            <div class="flex items-center gap-8 shrink-0">
                <div class="flex items-center">
                    <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'client.dashboard') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="block h-10 w-10 sm:h-12 sm:w-12 rounded-full object-cover shadow-sm">
                    </a>
                </div>

                <div class="hidden sm:flex space-x-6 h-20">
                    <x-nav-link :href="route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'client.dashboard')" :active="request()->routeIs('client.dashboard') || request()->routeIs('admin.dashboard')">
                        {{ __('Trang chủ') }}
                    </x-nav-link>

                    @if(Auth::user()->role !== 'admin')
                        <x-nav-link :href="route('client.about')" :active="request()->routeIs('client.about')">
                            {{ __('Giới thiệu') }}
                        </x-nav-link>

                        <div class="hidden sm:flex sm:items-center relative h-full" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                            <button @click="open = ! open" 
                                    class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-semibold leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out h-full group">
                                Dịch vụ
                                <svg :class="{'rotate-180': open}" class="ml-1.5 h-4 w-4 fill-current text-gray-400 group-hover:text-gray-600 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                class="absolute top-[110%] left-0 w-60 rounded-2xl shadow-xl bg-white/70 backdrop-blur-md border border-white/60 ring-1 ring-black/5 focus:outline-none z-50 overflow-hidden"
                                style="display: none;">
                                
                                <div class="py-2">
                                    <a href="{{ route('client.dashboard', ['seats' => 4]) }}" class="block px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50/80 hover:text-blue-700 transition-colors">Thuê xe 4 chỗ</a>
                                    <a href="{{ route('client.dashboard', ['seats' => 7]) }}" class="block px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50/80 hover:text-blue-700 transition-colors">Thuê xe 7 chỗ</a>
                                    <a href="{{ route('client.dashboard', ['seats' => 16]) }}" class="block px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50/80 hover:text-blue-700 transition-colors">Thuê xe 16 chỗ</a>
                                    <a href="{{ route('client.dashboard', ['seats' => 29]) }}" class="block px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50/80 hover:text-blue-700 transition-colors">Thuê xe 29 chỗ</a>
                                    <a href="{{ route('client.dashboard', ['seats' => 45]) }}" class="block px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50/80 hover:text-blue-700 transition-colors">Thuê xe 45 chỗ</a>
                                    <a href="{{ route('client.dashboard', ['seats' => '11']) }}" class="block px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50/80 hover:text-blue-700 transition-colors">Thuê xe Limousine</a>                                                              
                                    <a href="{{ route('services.driver') }}" class="block px-5 py-2.5 text-sm font-bold text-gray-700 hover:bg-blue-100/80 transition-colors">Thuê xe có người lái</a>                                </div>
                            </div>
                        </div>
                        <x-nav-link :href="route('client.contact')" :active="request()->routeIs('client.contact')">
                            {{ __('Liên hệ') }}
                        </x-nav-link>
                        <x-nav-link :href="route('client.bookings.history')" :active="request()->routeIs('client.bookings.history')">
                            {{ __('Lịch sử') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="flex-1 flex justify-center w-full">
                @if(Auth::user()->role !== 'admin')
                    <form method="GET" action="{{ route('client.dashboard') }}" class="w-full max-w-md relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="w-full pl-4 pr-10 py-2 border border-gray-300 sm:border-2 sm:border-gray-800 rounded-full focus:ring-0 focus:border-blue-600 transition-colors text-sm" 
                               placeholder="Tìm xe...">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 sm:text-gray-800 hover:text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" sm:stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>
                @endif
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Hồ sơ cá nhân') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Đăng xuất') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="flex items-center sm:hidden">
                    <button @click="open = ! open" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'client.dashboard')" :active="request()->routeIs('client.dashboard')">
                {{ __('Trang chủ') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->role !== 'admin')
                <x-responsive-nav-link :href="route('client.about')" :active="request()->routeIs('client.about')">
                    {{ __('Giới thiệu') }}
                </x-responsive-nav-link>
                <div x-data="{ openService: false }" class="border-l-4 border-transparent">
                    <button @click="openService = !openService" class="w-full flex justify-between items-center pl-3 pr-4 py-2 text-left text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 focus:outline-none transition duration-150 ease-in-out">
                        Dịch vụ
                        <svg :class="{'rotate-180': openService}" class="ml-1 h-5 w-5 transform transition-transform text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button> 
                  <div x-show="openService" x-collapse class="bg-gray-50/50">
                    <a href="{{ route('client.dashboard', ['seats' => 4]) }}" class="block pl-8 pr-4 py-2.5 text-sm font-medium text-gray-500 hover:text-blue-600 hover:bg-blue-50/50">Thuê xe 4 chỗ</a>
                    <a href="{{ route('client.dashboard', ['seats' => 7]) }}" class="block pl-8 pr-4 py-2.5 text-sm font-medium text-gray-500 hover:text-blue-600 hover:bg-blue-50/50">Thuê xe 7 chỗ</a>
                    <a href="{{ route('client.dashboard', ['seats' => 16]) }}" class="block pl-8 pr-4 py-2.5 text-sm font-medium text-gray-500 hover:text-blue-600 hover:bg-blue-50/50">Thuê xe 16 chỗ</a>
                    <a href="{{ route('client.dashboard', ['seats' => 29]) }}" class="block pl-8 pr-4 py-2.5 text-sm font-medium text-gray-500 hover:text-blue-600 hover:bg-blue-50/50">Thuê xe 29 chỗ</a>
                    <a href="{{ route('client.dashboard', ['seats' => 45]) }}" class="block pl-8 pr-4 py-2.5 text-sm font-medium text-gray-500 hover:text-blue-600 hover:bg-blue-50/50">Thuê xe 45 chỗ</a>
                    <a href="{{ route('client.dashboard', ['seats' => '11']) }}" class="block pl-8 pr-4 py-2.5 text-sm font-medium text-gray-500 hover:text-blue-600 hover:bg-blue-50/50">Thuê xe Limousine</a>
                    <a href="{{ route('services.driver') }}" class="block pl-8 pr-4 py-2.5 text-sm font-bold text-gray-700 hover:bg-blue-100/50">Thuê xe có người lái</a>
                </div>
                </div>
                <x-responsive-nav-link :href="route('client.contact')" :active="request()->routeIs('client.contact')">
                    {{ __('Liên hệ') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('client.bookings.history')" :active="request()->routeIs('client.bookings.history')">
                    {{ __('Lịch sử') }}
                </x-responsive-nav-link>
            @endif
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Đăng xuất') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
<div class="fixed bottom-6 right-6 sm:bottom-8 sm:right-8 z-[9999]">
    <a href="{{ route('client.contact') }}" 
       class="flex items-center gap-3 bg-[#e85c2c] hover:bg-[#d04a1f] text-white px-4 py-4 sm:px-6 rounded-full shadow-2xl hover:shadow-orange-500/50 transition-all duration-300 hover:-translate-y-1 group relative">
        <span class="absolute inset-0 rounded-full bg-[#e85c2c] opacity-40 animate-ping -z-5"></span>
        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
    </a>
</div>
