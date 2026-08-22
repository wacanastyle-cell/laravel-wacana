@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
    $siteDescription = $siteSettings['site_description'] ?? 'Komunitas motor Jawa Tengah';
    $currentRoute = request()->route()?->getName() ?? '';

    $isMenuActive = function ($item) use ($currentRoute) {
        if (($item['route'] ?? '') === $currentRoute) {
            return true;
        }

        if (($item['route'] ?? '') === 'public.page') {
            return ($item['slug'] ?? null) === request()->route('slug');
        }

        return false;
    };
@endphp

<style>
.ws-header{
    position:absolute;
    top:0;
    left:0;
    right:0;
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
    width:38px;
    height:38px;
    border-radius:10px;
    display:grid;
    place-items:center;
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

.ws-nav-links > a,
.ws-nav-dropdown > button{
    color:#d4d4d8;
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.05em;
    transition:.2s;
    position:relative;
    background:none;
    border:0;
    cursor:pointer;
    padding:0;
}

.ws-nav-links > a:hover,
.ws-nav-dropdown > button:hover{
    color:#fff;
}

.ws-nav-links .ws-active{
    color:#fff;
}

.ws-nav-links .ws-active::after{
    content:"";
    position:absolute;
    bottom:-6px;
    left:0;
    right:0;
    height:2px;
    background:#ef0000;
}

.ws-nav-dropdown{
    position:relative;
}

.ws-nav-dropdown-menu{
    position:absolute;
    top:calc(100% + 18px);
    left:50%;
    transform:translateX(-50%) translateY(-6px);
    min-width:220px;
    padding:8px;
    background:#0d0d10;
    border:1px solid rgba(255,255,255,.1);
    border-radius:12px;
    box-shadow:0 18px 45px rgba(0,0,0,.4);
    opacity:0;
    visibility:hidden;
    pointer-events:none;
    transition:.2s ease;
}

.ws-nav-dropdown:hover .ws-nav-dropdown-menu,
.ws-nav-dropdown:focus-within .ws-nav-dropdown-menu{
    opacity:1;
    visibility:visible;
    pointer-events:auto;
    transform:translateX(-50%) translateY(0);
}

.ws-nav-dropdown-menu a{
    display:block;
    padding:11px 13px;
    border-radius:8px;
    color:#d4d4d8;
    font-size:10px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.04em;
}

.ws-nav-dropdown-menu a:hover,
.ws-nav-dropdown-menu a.ws-active{
    background:#18181b;
    color:#fff;
}

.ws-menu-btn{
    width:42px;
    height:42px;
    border-radius:10px;
    border:1px solid rgba(255,255,255,.13);
    background:rgba(0,0,0,.35);
    color:#fff;
    cursor:pointer;
    display:grid;
    place-items:center;
    font-size:16px;
}

.drawer-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.65);
    backdrop-filter:blur(3px);
    z-index:9990;
    opacity:0;
    visibility:hidden;
    transition:.3s;
}

.drawer-overlay.open{
    opacity:1;
    visibility:visible;
}

.side-drawer{
    position:fixed;
    right:0;
    top:0;
    bottom:0;
    width:min(380px,92vw);
    z-index:9991;
    background:#0d0d10;
    border-left:1px solid rgba(255,255,255,.1);
    padding:24px;
    transform:translateX(100%);
    transition:transform .35s cubic-bezier(.2,.8,.2,1);
    overflow-y:auto;
}

.side-drawer.open{
    transform:translateX(0);
}

.drawer-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.drawer-head strong{
    font-family:Montserrat;
}

.drawer-close{
    width:38px;
    height:38px;
    border-radius:9px;
    border:1px solid rgba(255,255,255,.1);
    background:#18181b;
    color:#fff;
    cursor:pointer;
}

.drawer-links{
    display:grid;
    gap:5px;
}

.drawer-links > a,
.drawer-about-toggle{
    width:100%;
    box-sizing:border-box;
    padding:15px;
    border-radius:10px;
    color:#d4d4d8;
    font-size:12px;
    font-weight:700;
    text-align:left;
    background:none;
    border:0;
    cursor:pointer;
}

.drawer-links > a:hover,
.drawer-about-toggle:hover,
.drawer-links > a.ws-active{
    background:#18181b;
    color:#fff;
}

.drawer-about-toggle{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.drawer-about-toggle i{
    transition:.2s;
}

.drawer-about.open .drawer-about-toggle i{
    transform:rotate(180deg);
}

.drawer-about-children{
    display:none;
    padding-left:12px;
}

.drawer-about.open .drawer-about-children{
    display:grid;
}

.drawer-about-children a{
    padding:12px 15px;
    border-radius:8px;
    color:#a1a1aa;
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
}

.drawer-about-children a:hover,
.drawer-about-children a.ws-active{
    background:#18181b;
    color:#fff;
}

.drawer-cta{
    margin-top:22px;
}

@media(max-width:768px){
    .ws-nav-links{
        display:none;
    }
}
.ws-brand-logo{display:block;width:auto;height:52px;max-width:240px;object-fit:contain;}
.ws-brand-text{display:flex;flex-direction:column;line-height:1.1;margin-left:0}.ws-brand-text strong{font-family:Montserrat,Arial,sans-serif;font-size:18px;font-weight:900;letter-spacing:-.03em;color:#ef0000}.ws-brand-text small{display:block;color:#a1a1aa;font-size:9px;font-weight:600;letter-spacing:.14em;margin-top:4px}
.ws-word-white{color:#f4f4f5!important;}
.ws-word-red{color:#ef0000!important;}
</style>

<header class="ws-header">
    <div class="ws-nav-inner">
        <a href="{{ route('home') }}" class="ws-brand" aria-label="Wacana Style">
            <img src="{{ asset('storage/icon-logo/logo.png') }}" alt="Wacana Style" class="ws-brand-logo">
            <div class="ws-brand-text">
                <strong><span class="ws-word-white">WACANA</span> <span class="ws-word-red">STYLE</span></strong>
                <small>Komunitas motor tegal</small>
            </div>
        </a>
        </a>

        {{-- DESKTOP NAVIGATION --}}
        <nav class="ws-nav-links">
            @foreach($mainMenu as $item)
                @if(($item['type'] ?? 'link') === 'dropdown')
                    @php
                        $aboutActive = collect($item['children'] ?? [])->contains(
                            fn ($child) => $isMenuActive($child)
                        );
                    @endphp

                    <div class="ws-nav-dropdown">
                        <button type="button" class="{{ $aboutActive ? 'ws-active' : '' }}">
                            {{ $item['title'] }}
                            <i class="fa-solid fa-chevron-down" style="font-size:8px;margin-left:4px"></i>
                        </button>

                        <div class="ws-nav-dropdown-menu">
                            @foreach($item['children'] ?? [] as $child)
                                <a
                                    href="{{ $child['url'] }}"
                                    class="{{ $isMenuActive($child) ? 'ws-active' : '' }}"
                                >
                                    {{ $child['title'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a
                        href="{{ $item['url'] }}"
                        class="{{ $isMenuActive($item) ? 'ws-active' : '' }}"
                    >
                        {{ $item['title'] }}
                    </a>
                @endif
            @endforeach
        </nav>

        <button
            class="ws-menu-btn"
            type="button"
            onclick="toggleDrawer()"
            aria-label="Buka menu"
        >
            <i class="fa-solid fa-bars"></i>
        </button>

    </div>
</header>

<div id="drawerOverlay" class="drawer-overlay" onclick="toggleDrawer(false)"></div>

<aside id="sideDrawer" class="side-drawer" aria-label="Menu">

    <div class="drawer-head">
        <strong>{{ $siteName }}</strong>

        <button
            class="drawer-close"
            type="button"
            onclick="toggleDrawer(false)"
            aria-label="Tutup menu"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    {{-- MOBILE NAVIGATION: SUMBER DATA SAMA DENGAN DESKTOP --}}
    <div class="drawer-links">

        @foreach($mainMenu as $item)

            @if(($item['type'] ?? 'link') === 'dropdown')

                @php
                    $aboutActive = collect($item['children'] ?? [])->contains(
                        fn ($child) => $isMenuActive($child)
                    );
                @endphp

                <div class="drawer-about {{ $aboutActive ? 'open' : '' }}">

                    <button
                        type="button"
                        class="drawer-about-toggle"
                        onclick="toggleAbout(this)"
                        aria-expanded="{{ $aboutActive ? 'true' : 'false' }}"
                    >
                        <span>{{ $item['title'] }}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>

                    <div class="drawer-about-children">

                        @foreach($item['children'] ?? [] as $child)

                            <a
                                href="{{ $child['url'] }}"
                                class="{{ $isMenuActive($child) ? 'ws-active' : '' }}"
                                onclick="toggleDrawer(false)"
                            >
                                {{ $child['title'] }}
                            </a>

                        @endforeach

                    </div>

                </div>

            @else

                <a
                    href="{{ $item['url'] }}"
                    class="{{ $isMenuActive($item) ? 'ws-active' : '' }}"
                    onclick="toggleDrawer(false)"
                >
                    {{ $item['title'] }}
                </a>

            @endif

        @endforeach

    </div>

    <div class="drawer-cta">
        <a
            href="https://wacanastyle.my.id/page/gabung-member-wacana-style-komunitas-motor"
            class="btn btn-red"
            style="width:100%"
            onclick="toggleDrawer(false)"
        >
            <i class="fa-solid fa-user-plus"></i>
            Gabung Sekarang
        </a>
    </div>

</aside>

<script>
function toggleDrawer(force) {
    const drawer = document.getElementById('sideDrawer');
    const overlay = document.getElementById('drawerOverlay');

    if (!drawer || !overlay) return;

    const open = typeof force === 'boolean'
        ? force
        : !drawer.classList.contains('open');

    drawer.classList.toggle('open', open);
    overlay.classList.toggle('open', open);

    document.body.style.overflow = open ? 'hidden' : '';
}

function toggleAbout(button) {
    const wrapper = button.closest('.drawer-about');

    if (!wrapper) return;

    const isOpen = wrapper.classList.toggle('open');

    button.setAttribute(
        'aria-expanded',
        isOpen ? 'true' : 'false'
    );
}
</script>

<style>
/* FIX: jangan biarkan CSS konten Page memengaruhi link navigasi */
header a,
header a:hover,
header a:focus,
header a:active,
header a:visited {
    text-decoration: none !important;
}
</style>

<style id="ws-drawer-unified-fix">

/* ==================================================
   WACANA STYLE - UNIFIED MOBILE DRAWER
   Berlaku sama di seluruh halaman publik
================================================== */

.side-drawer {
    position: fixed !important;
    top: 0 !important;
    right: 0 !important;

    width: min(430px, 92vw) !important;
    height: 100dvh !important;
    min-height: 100vh !important;

    padding: 26px 28px !important;

    background: #0b0b0e !important;

    border-left: 1px solid rgba(255,255,255,.08) !important;

    box-shadow:
        -25px 0 70px rgba(0,0,0,.45) !important;

    z-index: 99999 !important;

    overflow-y: auto !important;
    overflow-x: hidden !important;

    transform: translateX(105%) !important;

    visibility: hidden !important;
    opacity: 0 !important;

    transition:
        transform .35s ease,
        opacity .25s ease,
        visibility .35s ease !important;
}


/* DRAWER OPEN */

.side-drawer.open {
    transform: translateX(0) !important;

    visibility: visible !important;
    opacity: 1 !important;
}


/* HEADER DRAWER */

.side-drawer .drawer-header {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;

    margin-bottom: 32px !important;
}


.side-drawer .drawer-title {
    margin: 0 !important;

    color: #fff !important;

    font-size: 20px !important;
    font-weight: 800 !important;
}


/* CLOSE BUTTON */

.side-drawer .drawer-close {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    width: 46px !important;
    height: 46px !important;

    padding: 0 !important;

    border: 1px solid rgba(255,255,255,.12) !important;
    border-radius: 12px !important;

    background: #131318 !important;

    color: #fff !important;

    cursor: pointer !important;
}


/* NAVIGATION */

.side-drawer nav,
.side-drawer .drawer-nav {
    display: flex !important;
    flex-direction: column !important;

    gap: 4px !important;
}


.side-drawer nav > a,
.side-drawer .drawer-nav > a,
.side-drawer .drawer-link {
    display: flex !important;
    align-items: center !important;

    width: 100% !important;

    padding: 15px 16px !important;

    border-radius: 10px !important;

    color: #f4f4f5 !important;

    font-size: 14px !important;
    font-weight: 700 !important;

    text-decoration: none !important;

    transition:
        background .2s ease,
        color .2s ease !important;
}


.side-drawer nav > a:hover,
.side-drawer .drawer-nav > a:hover,
.side-drawer .drawer-link:hover {
    background: rgba(255,255,255,.05) !important;

    color: #ef2029 !important;
}


/* ABOUT DROPDOWN */

.side-drawer .drawer-dropdown-toggle {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;

    width: 100% !important;

    padding: 15px 16px !important;

    border: 0 !important;
    border-radius: 10px !important;

    background: transparent !important;

    color: #f4f4f5 !important;

    font-size: 14px !important;
    font-weight: 700 !important;

    text-align: left !important;
}


.side-drawer .drawer-dropdown-menu {
    padding: 4px 0 6px 14px !important;
}


/* CTA */

.side-drawer .drawer-cta {
    width: 100% !important;

    margin-top: 20px !important;
}


.side-drawer .drawer-cta .btn,
.side-drawer .drawer-cta .btn-red {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    gap: 10px !important;

    width: 100% !important;

    min-height: 56px !important;

    padding: 15px 20px !important;

    border: 0 !important;
    border-radius: 12px !important;

    background: #ef0b0b !important;

    color: #fff !important;

    font-size: 14px !important;
    font-weight: 800 !important;

    letter-spacing: .4px !important;

    text-decoration: none !important;

    box-shadow:
        0 12px 30px rgba(239,11,11,.16) !important;
}


.side-drawer .drawer-cta .btn:hover,
.side-drawer .drawer-cta .btn-red:hover {
    background: #cf0909 !important;

    color: #fff !important;

    transform: translateY(-1px) !important;
}


/* OVERLAY */

.drawer-overlay {
    position: fixed !important;
    inset: 0 !important;

    z-index: 99990 !important;

    background: rgba(0,0,0,.68) !important;

    backdrop-filter: blur(5px) !important;
    -webkit-backdrop-filter: blur(5px) !important;
}


/* TABLET */

@media (max-width: 768px) {

    .side-drawer {
        width: min(430px, 92vw) !important;

        padding:
            24px
            25px
            40px !important;
    }

}


/* HP KECIL */

@media (max-width: 480px) {

    .side-drawer {
        width: 88vw !important;
        max-width: 390px !important;

        padding:
            22px
            20px
            35px !important;
    }

    .side-drawer .drawer-cta .btn,
    .side-drawer .drawer-cta .btn-red {
        min-height: 54px !important;

        font-size: 13px !important;
    }

}

</style>


<style id="ws-global-link-fix">

/* ==================================================
   WACANA STYLE - GLOBAL LINK STYLE
   Hilangkan underline di seluruh website publik
================================================== */

a,
a:link,
a:visited,
a:hover,
a:focus,
a:active {
    text-decoration: none !important;
}


/* Pastikan elemen link turunan juga tidak mendapat garis */

a *,
a:hover *,
a:focus *,
a:active * {
    text-decoration: none !important;
}


/* HEADER */

header a,
header a:hover,
header a:focus,
header a:active,
header a:visited {
    text-decoration: none !important;
}


/* NAVIGATION */

nav a,
nav a:hover,
nav a:focus,
nav a:active,
nav a:visited {
    text-decoration: none !important;
}


/* SIDE DRAWER */

.side-drawer a,
.side-drawer a:hover,
.side-drawer a:focus,
.side-drawer a:active,
.side-drawer a:visited {
    text-decoration: none !important;
}


/* FOOTER */

footer a,
footer a:hover,
footer a:focus,
footer a:active,
footer a:visited {
    text-decoration: none !important;
}


/* BLOG */

.blog-content a,
.blog-content a:hover,
.ws-tour-blog a,
.ws-tour-blog a:hover {
    text-decoration: none !important;
}


/* PAGE CMS */

.page-content a,
.page-content a:hover,
.ws-page-content a,
.ws-page-content a:hover {
    text-decoration: none !important;
}


/* FORM */

.form-card a,
.form-card a:hover,
.form-body a,
.form-body a:hover {
    text-decoration: none !important;
}


/* GALLERY */

.gallery-card,
.gallery-card:hover,
.gallery-card a,
.gallery-card a:hover {
    text-decoration: none !important;
}


/* FAQ */

.faq-item a,
.faq-item a:hover {
    text-decoration: none !important;
}


/* BUTTON / CTA */

.btn,
.btn:hover,
.btn:focus,
.btn:active,
button a,
button a:hover,
.drawer-cta a,
.drawer-cta a:hover {
    text-decoration: none !important;
}

</style>

