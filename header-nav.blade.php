<header class="bg-gray-800 text-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-red-400">{{ $siteSettings['site_name'] ?? 'Wacana Style' }}</a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-6 h-full"> {{-- mainMenu is now passed from View Composer --}}
                @foreach($mainMenu as $menuItem)
                    @if($menuItem['type'] === 'link')
                        <a href="{{ $menuItem['url'] }}" class="hover:text-red-400">{{ $menuItem['title'] }}</a>
                    @elseif($menuItem['type'] === 'dropdown')
                        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative group">
                            <button class="flex items-center hover:text-red-400 focus:outline-none">
                                {{ $menuItem['title'] }}
                                <svg class="ml-1 w-4 h-4 transition-transform duration-200 transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute left-0 mt-2 w-48 bg-gray-700 rounded-md shadow-lg py-1 z-20 hidden group-hover:block"
                            >
                                @foreach($menuItem['children'] as $child)
                                    <a href="{{ $child['url'] }}" class="block px-4 py-2 text-sm text-white hover:bg-gray-600 hover:text-red-400">{{ $child['title'] }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                {{-- Admin links are separate as they are conditional based on auth status --}}
                <div class="pl-6 border-l border-gray-700">
                    @auth('web')
                        <a href="{{ route('filament.admin.dashboard') }}" class="ws-nav-admin-link hover:text-red-400">Admin</a>
                    @else
                        <a href="{{ route('filament.admin.auth.login') }}" class="ws-nav-admin-link hover:text-red-400">Admin Login</a>
                    @endauth
                </div>
            </nav>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button onclick="toggleDrawer()" class="text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Menu (Sidebar) -->
    <div id="mobile-drawer" class="fixed top-0 left-0 h-full w-64 bg-gray-900 text-white transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden z-50">
        <div class="p-5">
            <button onclick="toggleDrawer()" class="absolute top-4 right-4 text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h2 class="text-2xl font-bold mb-6 text-red-400">{{ $siteSettings['site_name'] ?? 'Wacana Style' }}</h2>
            <nav class="flex flex-col space-y-4">
                @foreach($mainMenu as $menuItem)
                    @if($menuItem['type'] === 'link')
                        <a href="{{ $menuItem['url'] }}" class="hover:text-red-400">{{ $menuItem['title'] }}</a>
                    @elseif($menuItem['type'] === 'dropdown')
                        <div>
                            <button onclick="toggleAboutSubmenu()" class="flex items-center justify-between w-full text-left hover:text-red-400 focus:outline-none">
                                {{ $menuItem['title'] }}
                                <svg id="mobile-about-toggle-icon" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div id="mobile-about-submenu" class="pl-4 mt-2 space-y-2 hidden">
                                @foreach($menuItem['children'] as $child)
                                    <a href="{{ $child['url'] }}" class="block text-sm text-gray-300 hover:text-red-400">{{ $child['title'] }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                <hr class="border-gray-700 my-2">
                @auth('web')
                    <a href="{{ route('filament.admin.dashboard') }}" class="hover:text-red-400">Admin</a>
                @else
                    <a href="{{ route('filament.admin.auth.login') }}" class="hover:text-red-400">Admin Login</a>
                @endauth
            </nav>
        </div>
    </div>
</header>

{{-- Alpine.js for desktop dropdown (if not already included globally) --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    function toggleDrawer() {
        const drawer = document.getElementById('mobile-drawer');
        drawer.classList.toggle('-translate-x-full');
        // Toggle body overflow to prevent scrolling when drawer is open
        document.body.classList.toggle('overflow-hidden');
    }

    function toggleAboutSubmenu() {
        const submenu = document.getElementById('mobile-about-submenu');
        const icon = document.getElementById('mobile-about-toggle-icon');
        submenu.classList.toggle('hidden'); // Toggle visibility
        icon.classList.toggle('rotate-180'); // Rotate icon for visual feedback
    }
</script>