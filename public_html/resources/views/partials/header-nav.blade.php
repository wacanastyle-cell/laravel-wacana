@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
    $siteDescription = $siteSettings['site_description'] ?? 'Komunitas motor Jawa Tengah';
    $isHomePage = request()->route() && request()->route()->getName() === 'home';
    $isLanding = request()->route() && request()->route()->getName() === 'landing';
    $currentRoute = request()->route() ? request()->route()->getName() : '';

// Check if user is authenticated
$isAdminAuthenticated = auth()->check() && auth()->user()?->hasRole('admin');
@endphp

<style>
/* Shared Navigation Styles */
.ws-header{
    position:absolute;
    top:0;left:0;right:0;
    z-index:20;
    padding:18px 0;
    background:rgba(8,8,10,.85);
    backdrop-filter:blur(12px);
}
.ws-header .ws-nav-inner{
    width:min(1200px,calc(100% - 32px));
    margin:auto;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
}
.ws-brand{
    display:flex;
    align-items:center;
    gap:11px;
    font-family:Montserrat,Arial,sans-serif;
    font-weight:900;
    letter-spacing:-.03em;
}
.ws-brand-mark{
    width:38px;height:38px;
    border-radius:10px;
    display:grid;place-items:center;
    background:linear-gradient(135deg,#ef0000,#8b0000);
    box-shadow:0 8px 25px rgba(239,0,0,.25);
}
.ws-brand small{
    display:block;
    color:#a1a1aa;
    font-size:8px;
    font-weight:600;
    letter-spacing:.17em;
}
.ws-nav-links{
    display:flex;
    align-items:center;
    gap:24px;
}
.ws-nav-links > div {
    position: relative;
}
.ws-nav-links a, .ws-nav-dropdown-btn{
    color:#d4d4d8;
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.05em;
    transition:.2s;
    position:relative;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
}
.ws-nav-links a:hover, .ws-nav-dropdown-btn:hover{color:#fff}
.ws-nav-links a.ws-active, .ws-nav-dropdown-btn.ws-active{color:#fff}
.ws-nav-links a.ws-active::after, .ws-nav-dropdown-btn.ws-active::after{
    content:"";
    position:absolute;
    bottom:-6px;left:0;right:0;
    height:2px;
    background:#ef0000;
}
.ws-nav-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 200px;
    background: #18181b;
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 8px;
    padding: 8px 0;
    margin-top: 12px;
    display: none;
    flex-direction: column;
    z-index: 50;
}
.ws-nav-dropdown.open {
    display: flex;
}
.ws-nav-dropdown a {
    padding: 12px 16px;
    color: #d4d4d8;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    white-space: nowrap;
    transition: .2s;
}
.ws-nav-dropdown a:hover {
    background: rgba(239,0,0,.15);
    color: #fff;
}
.ws-nav-admin-link{
    padding:8px 14px;
    background:rgba(239,0,0,.15);
    border:1px solid rgba(239,0,0,.4);
    border-radius:8px;
    color:#fca5a5;
    font-size:10px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.08em;
    transition:.2s;
    display: flex;
    align-items: center;
}
.ws-nav-admin-link:hover{
    background:rgba(239,0,0,.25);
    border-color:rgba(239,0,0,.6);
    color:#fff;
}
.ws-menu-btn{
    width:42px;height:42px;
    border-radius:10px;
    border:1px solid rgba(255,255,255,.13);
    background:rgba(0,0,0,.35);
    color:#fff;
    cursor:pointer;
    display:grid;place-items:center;
    font-size:16px;
}
.drawer-overlay{
    position:fixed;inset:0;background:rgba(0,0,0,.65);
    backdrop-filter:blur(3px);z-index:9990;opacity:0;visibility:hidden;
    transition:.3s;
}
.drawer-overlay.open{opacity:1;visibility:visible}
.side-drawer{
    position:fixed;right:0;top:0;bottom:0;width:min(380px,92vw);
    z-index:9991;background:#0d0d10;
    border-left:1px solid rgba(255,255,255,.1);
    padding:24px;
    transform:translateX(100%);
    transition:transform .35s cubic-bezier(.2,.8,.2,1);
    overflow-y:auto;
}
.side-drawer.open{transform:translateX(0)}
.drawer-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px}
.drawer-head strong{font-family:Montserrat}
.drawer-close{
    width:38px;height:38px;border-radius:9px;
    border:1px solid rgba(255,255,255,.1);
    background:#18181b;color:#fff;cursor:pointer;
}
.drawer-links{display:grid;gap:5px}
.drawer-links a, .drawer-submenu-btn {
    padding:15px;border-radius:10px;color:#d4d4d8;
    font-size:12px;font-weight:700;
    background: none;
    border: none;
    cursor: pointer;
    width: 100%;
    text-align: left;
    transition: .2s;
}
.drawer-links a:hover, .drawer-submenu-btn:hover{background:#18181b;color:#fff}
.drawer-submenu-items {
    display: none;
    flex-direction: column;
    gap: 0;
    padding-left: 8px;
    margin-top: 8px;
}
.drawer-submenu-items.open {
    display: flex;
}
.drawer-submenu-items a {
    padding: 12px 12px;
    font-size: 11px;
    background: rgba(239,0,0,.08);
    color: #a1a1a6;
}
.drawer-submenu-items a:hover {
    background: rgba(239,0,0,.15);
    color: #fff;
}
.drawer-cta{margin-top:22px}
@media(max-width:768px){
    .ws-nav-links{display:none}
}
</style>

<header class="ws-header">
    <div class="ws-nav-inner">
        <a href="{{ route('home') }}" class="ws-brand" aria-label="{{ $siteName }}">
            <div class="ws-brand-mark"><i class="fa-solid fa-motorcycle"></i></div>
            <div>
                {{ $siteName }}
                <small>{{ $siteDescription }}</small>
            </div>
        </a>

        <nav class="ws-nav-links">
            @if(isset($wsNavLinks))
                @foreach($wsNavLinks as $link)
                    @if($link['type'] === 'menu')
                        <!-- Desktop Dropdown Menu -->
                        <div>
                            <button class="ws-nav-dropdown-btn" onclick="toggleNavDropdown(event)">
                                {{ $link['label'] }}
                                <i class="fa-solid fa-chevron-down" style="margin-left: 6px; font-size: 8px;"></i>
                            </button>
                            <div class="ws-nav-dropdown">
                                @foreach($link['items'] as $subitem)
                                    @if(isset($subitem['url']))
                                        <a href="{{ $subitem['url'] }}" target="_blank">{{ $subitem['label'] }}</a>
                                    @elseif(isset($subitem['route']))
                                        <a href="{{ route($subitem['route'], $subitem['slug'] ?? null) }}">{{ $subitem['label'] }}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Desktop Regular Link -->
                        @if(isset($link['url']))
                            <div><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></div>
                        @elseif(isset($link['route']))
                            <div><a href="{{ route($link['route']) }}">{{ $link['label'] }}</a></div>
                        @endif
                    @endif
                @endforeach
            @endif

            @php
                $adminDashboardRoute = Route::has('filament.admin.pages.dashboard')
                    ? route('filament.admin.pages.dashboard')
                    : '/admin';
                $adminLoginRoute = Route::has('filament.admin.auth.login')
                    ? route('filament.admin.auth.login')
                    : '/admin/login';
            @endphp
        </nav>

        <button class="ws-menu-btn" type="button" onclick="toggleDrawer()" aria-label="Buka menu">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</header>

<div id="drawerOverlay" class="drawer-overlay" onclick="toggleDrawer(false)"></div>
<aside id="sideDrawer" class="side-drawer" aria-label="Menu">
    <div class="drawer-head">
        <strong>{{ $siteName }}</strong>
        <button class="drawer-close" type="button" onclick="toggleDrawer(false)">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="drawer-links">
        @if(isset($wsNavLinks))
            @foreach($wsNavLinks as $link)
                @if($link['type'] === 'menu')
                    <!-- Mobile Submenu -->
                    <button class="drawer-submenu-btn" onclick="toggleDrawerSubmenu(event)">
                        {{ $link['label'] }}
                        <i class="fa-solid fa-chevron-down" style="margin-left: 8px; float: right; font-size: 10px;"></i>
                    </button>
                    <div class="drawer-submenu-items">
                        @foreach($link['items'] as $subitem)
                            @if(isset($subitem['url']))
                                <a href="{{ $subitem['url'] }}" target="_blank" onclick="toggleDrawer(false)">{{ $subitem['label'] }}</a>
                            @elseif(isset($subitem['route']))
                                <a href="{{ route($subitem['route'], $subitem['slug'] ?? null) }}" onclick="toggleDrawer(false)">{{ $subitem['label'] }}</a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <!-- Mobile Regular Link -->
                    @if(isset($link['url']))
                        <a href="{{ $link['url'] }}" onclick="toggleDrawer(false)">{{ $link['label'] }}</a>
                    @elseif(isset($link['route']))
                        <a href="{{ route($link['route']) }}" onclick="toggleDrawer(false)">{{ $link['label'] }}</a>
                    @endif
                @endif
            @endforeach
        @endif

        <div style="height:1px;background:rgba(255,255,255,.1);margin:12px 0"></div>

        @auth
        @else
        @endauth
    </div>

    <div class="drawer-cta">
        <a href="{{ route('public.forms') }}" class="btn btn-red" style="width:100%" onclick="toggleDrawer(false)">
            <i class="fa-solid fa-user-plus"></i> Formulir
        </a>
    </div>
</aside>

<script>
    function toggleDrawer(force){
        const drawer = document.getElementById('sideDrawer');
        const overlay = document.getElementById('drawerOverlay');
        const open = typeof force === 'boolean' ? force : !drawer.classList.contains('open');

        drawer.classList.toggle('open', open);
        overlay.classList.toggle('open', open);
    }

    function toggleNavDropdown(event) {
        event.preventDefault();
        const dropdown = event.target.closest('div').querySelector('.ws-nav-dropdown');
        
        // Close other dropdowns
        document.querySelectorAll('.ws-nav-dropdown.open').forEach(el => {
            if (el !== dropdown) {
                el.classList.remove('open');
            }
        });
        
        dropdown.classList.toggle('open');
    }

    function toggleDrawerSubmenu(event) {
        event.preventDefault();
        const btn = event.currentTarget;
        const submenu = btn.nextElementSibling;
        
        // Close other submenus
        document.querySelectorAll('.drawer-submenu-items.open').forEach(el => {
            if (el !== submenu) {
                el.classList.remove('open');
            }
        });
        
        submenu.classList.toggle('open');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.ws-nav-links')) {
            document.querySelectorAll('.ws-nav-dropdown.open').forEach(el => {
                el.classList.remove('open');
            });
        }
    });
</script>
