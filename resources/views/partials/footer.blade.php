@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
    $footerText = $siteSettings['footer_text'] ?? 'Satu Aspal, Satu Keluarga';
@endphp

<style>
.ws-footer{
    padding:64px 0 24px;
    border-top:1px solid rgba(255,255,255,.07);
    background:#070709;
    margin-top:48px;
}

.ws-footer-grid{
    width:min(1200px,calc(100% - 32px));
    margin:auto;
    display:grid;
    grid-template-columns:1.5fr 1fr 1.25fr 1fr;
    gap:55px;
    align-items:start;
}

.ws-footer-brand{
    min-width:0;
}

.ws-footer-brand-main{
    display:flex;
    align-items:center;
    gap:14px;
}

.ws-footer-logo{
    width:58px;
    height:58px;
    flex:0 0 58px;
    object-fit:contain;
}

.ws-footer-brand-text{
    display:flex;
    flex-direction:column;
    line-height:1.1;
}

.ws-footer-brand-text strong{
    font-family:Montserrat,Arial,sans-serif;
    font-size:20px;
    font-weight:900;
    color:#ef0000;
    letter-spacing:-.04em;
}

.ws-footer-brand-text small{
    display:block;
    margin-top:6px;
    color:#a1a1aa;
    font-size:9px;
    font-weight:600;
    letter-spacing:.13em;
}

.ws-footer-description{
    max-width:320px;
    margin:18px 0 0;
    color:#71717a;
    font-size:11px;
    line-height:1.8;
}

.ws-footer-title{
    font-family:Montserrat,Arial,sans-serif;
    font-size:11px;
    font-weight:800;
    margin:0 0 18px;
    color:#fca5a5;
    text-transform:uppercase;
    letter-spacing:.04em;
}

.ws-footer-links{
    display:grid;
    gap:11px;
}

.ws-footer-links a{
    display:flex;
    align-items:center;
    gap:8px;
    color:#71717a;
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.05em;
    transition:color .2s ease, transform .2s ease;
}

.ws-footer-links a:hover{
    color:#fff;
    transform:translateX(3px);
}

.ws-footer-links i{
    width:15px;
    text-align:center;
    font-size:12px;
}

.ws-footer-contact a{
    text-transform:none;
    letter-spacing:.02em;
}

.ws-copyright{
    width:min(1200px,calc(100% - 32px));
    margin:48px auto 0;
    padding-top:20px;
    border-top:1px solid rgba(255,255,255,.06);
    color:#52525b;
    font-size:10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    flex-wrap:wrap;
}

.ws-copyright span:last-child{
    text-align:right;
}

@media(max-width:900px){
    .ws-footer-grid{
        grid-template-columns:1.4fr 1fr 1fr;
        gap:35px;
    }

    .ws-footer-brand{
        grid-column:1 / -1;
    }
}

@media(max-width:640px){
    .ws-footer{
        padding:48px 0 22px;
    }

    .ws-footer-grid{
        grid-template-columns:1fr 1fr;
        gap:32px 24px;
    }

    .ws-footer-brand{
        grid-column:1 / -1;
    }

    .ws-footer-contact{
        grid-column:1 / -1;
    }

    .ws-copyright{
        margin-top:35px;
        align-items:flex-start;
        flex-direction:column;
    }

    .ws-copyright span:last-child{
        text-align:left;
    }
}

@media(max-width:420px){
    .ws-footer-grid{
        grid-template-columns:1fr;
    }

    .ws-footer-brand,
    .ws-footer-contact{
        grid-column:auto;
    }
}
.ws-word-white{color:#f4f4f5!important;}
.ws-word-red{color:#ef0000!important;}
</style>

<footer class="ws-footer">
    <div class="ws-footer-grid">

        {{-- BRAND --}}
        <div class="ws-footer-brand">
            <div class="ws-footer-brand-main">
                <img
                    src="{{ asset('storage/icon-logo/logo.png') }}"
                    alt="Wacana Style"
                    class="ws-footer-logo"
                >

                <div class="ws-footer-brand-text">
                    <strong><span class="ws-word-white">WACANA</span> <span class="ws-word-red">STYLE</span></strong>
                    <small>Komunitas motor tegal</small>
                </div>
            </div>

            <p class="ws-footer-description">
                Komunitas motor yang mengutamakan persaudaraan,
                kebersamaan, dan satu aspal.
            </p>
        </div>

        {{-- NAVIGASI --}}
        <div>
            <div class="ws-footer-title">NAVIGASI</div>

            <div class="ws-footer-links">
                <a href="{{ route('home') }}">Beranda</a>


                <a href="{{ route('public.galleries') }}">Galeri</a>

                <a href="{{ route('public.form.show', 'open-po-jaket') }}">Formulir</a>

                <a href="{{ route('public.blogs') }}">Blog</a>

                <a href="{{ route('public.page', 'tentang') }}">About</a>
            </div>
        </div>

        {{-- KONTAK --}}
        <div class="ws-footer-contact">
            <div class="ws-footer-title">KONTAK</div>

            <div class="ws-footer-links">
                <a
                    href="https://wa.me/6289520273357"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>+62 895-2027-3357</span>
                </a>

                <a
                    href="https://www.instagram.com/idris.studio855/"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <i class="fa-brands fa-instagram"></i>
                    <span>@idris.studio855</span>
                <a href="mailto:wacanastyle@gmail.com">
                    <i class="fa-solid fa-envelope"></i>
                    <span>wacanastyle@gmail.com</span>
                </a>

                <a href="mailto:admin@wacanastyle.my.id">
                    <i class="fa-solid fa-envelope"></i>
                    <span>admin@wacanastyle.my.id</span>
                </a>
                </a>
            </div>
        </div>

        {{-- SOSMED --}}
        <div>
            <div class="ws-footer-title">SOSMED</div>

            <div class="ws-footer-links">
                <a
                    href="https://www.tiktok.com/@wcnastyle"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <i class="fa-brands fa-tiktok"></i>
                    <span>@wcnastyle</span>
                </a>
            </div>
        </div>

    </div>

    <div class="ws-copyright">
        <span>
            © {{ date('Y') }} {{ $siteName }}. Semua hak cipta dilindungi.
        </span>

        <span>
            {{ $footerText }}
        </span>
    </div>
</footer>
