<nav x-data="{ mobileOpen: false }" class="fixed top-0 inset-x-0 z-50 bg-white/95 backdrop-blur-lg border-b border-gray-100">
    <div class="container-page">
        <div class="flex justify-between h-16 lg:h-18 items-center">
            <div class="flex items-center shrink-0">
                <a href="/">
                    <img src="{{ asset('logo.png') }}" alt="EventsDomain" class="h-10 object-contain">
                </a>
            </div>

            <div class="hidden lg:flex lg:items-center lg:justify-center lg:flex-1 lg:gap-0.5">
                <a href="{{ route('events.index', ['sort' => 'upcoming']) }}" class="nav-link {{ request()->routeIs('events.*') ? 'nav-link-active' : 'nav-link-inactive' }}">Browse Events</a>
                <a href="/#how-it-works" class="nav-link {{ request()->path() === '/' ? 'nav-link-active' : 'nav-link-inactive' }}">How It Works</a>
                <a href="/#sponsors" class="nav-link {{ request()->path() === '/' ? 'nav-link-active' : 'nav-link-inactive' }}">Sponsors</a>
                <a href="/partners" class="nav-link {{ request()->routeIs('partners.*') ? 'nav-link-active' : 'nav-link-inactive' }}">Partners</a>
                <a href="{{ route('roi-calculator') }}" class="nav-link {{ request()->routeIs('roi-calculator') ? 'nav-link-active' : 'nav-link-inactive' }}">ROI Calculator</a>
            </div>

            <div class="hidden lg:flex lg:items-center lg:gap-3">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition px-4 py-2">Sign In</a>
                <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 bg-terracotta-500 hover:bg-terracotta-600 text-white text-sm font-semibold rounded-lg transition shadow-sm">List Your Event</a>
            </div>

            <div class="flex items-center lg:hidden">
                <button @click="mobileOpen = !mobileOpen" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" x-cloak class="lg:hidden bg-white border-b border-gray-100 shadow-lg">
        <div class="container-page py-4 space-y-1">
            <a href="{{ route('events.index', ['sort' => 'upcoming']) }}" @click="mobileOpen = false" class="block px-4 py-3 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition">Browse Events</a>
            <a href="/#how-it-works" @click="mobileOpen = false" class="block px-4 py-3 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition">How It Works</a>
            <a href="/#sponsors" @click="mobileOpen = false" class="block px-4 py-3 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition">Sponsors</a>
            <a href="/partners" @click="mobileOpen = false" class="block px-4 py-3 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition">Partners</a>
            <a href="{{ route('roi-calculator') }}" @click="mobileOpen = false" class="block px-4 py-3 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition">ROI Calculator</a>
            <div class="divider my-2"></div>
            <a href="{{ route('login') }}" @click="mobileOpen = false" class="block px-4 py-3 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition">Sign In</a>
            <a href="{{ route('register') }}" @click="mobileOpen = false" class="block text-center px-5 py-3 bg-terracotta-500 hover:bg-terracotta-600 text-white font-semibold rounded-xl transition mt-2">List Your Event</a>
        </div>
    </div>
</nav>
