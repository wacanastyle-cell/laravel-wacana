@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
    $siteDescription = $siteSettings['site_description'] ?? 'Komunitas motor Jawa Tengah';
    $contactEmail = $siteSettings['contact_email'] ?? $siteSettings['email'] ?? 'admin@wacanastyle.my.id';
    $whatsapp = $siteSettings['whatsapp'] ?? '08123456789';
    $instagram = $siteSettings['instagram'] ?? '@wacanastyle';
    $address = $siteSettings['address'] ?? 'Jawa Tengah';
    $footerText = $siteSettings['footer_text'] ?? 'Satu Aspal, Satu Keluarga';
@endphp

<style>
/* Shared Footer Styles */
.ws-footer{
    padding:45px 0 25px;
    border-top:1px solid rgba(255,255,255,.07);
    background:#070709;
    margin-top:48px;
}
.ws-footer-grid{
    width:min(1200px,calc(100% - 32px));
    margin:auto;
    display:grid;
    grid-template-columns:1.3fr 1fr 1fr 1fr;
    gap:40px;
}
.ws-footer-brand p{
    max-width:400px;
    color:#71717a;
    font-size:11px;
    line-height:1.8;
}
.ws-footer-title{
    font-family:Montserrat,Arial,sans-serif;
    font-size:11px;
    font-weight:800;
    margin-bottom:13px;
    color:#fca5a5;
}
.ws-footer-links{
    display:grid;
    gap:8px;
}
.ws-footer-links a{
    color:#71717a;
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.05em;
    transition:.2s;
}
.ws-footer-links a:hover{
    color:#fff;
}
.ws-footer .ws-brand{
    display:flex;
    align-items:center;
    gap:11px;
    font-family:Montserrat,Arial,sans-serif;
    font-weight:900;
    letter-spacing:-.03em;
}
.ws-footer .ws-brand-mark{
    width:38px;height:38px;
    border-radius:10px;
    display:grid;place-items:center;
    background:linear-gradient(135deg,#ef0000,#8b0000);
    box-shadow:0 8px 25px rgba(239,0,0,.25);
}
.ws-footer .ws-brand small{
    display:block;
    color:#a1a1aa;
    font-size:8px;
    font-weight:600;
    letter-spacing:.17em;
}
.ws-copyright{
    margin-top:35px;
    padding-top:20px;
    border-top:1px solid rgba(255,255,255,.06);
    color:#52525b;
    font-size:10px;
    display:flex;
    justify-content:space-between;
    gap:15px;
    flex-wrap:wrap;
}
@media(max-width:768px){
    .ws-footer-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:640px){
    .ws-footer-grid{grid-template-columns:1fr}
}
</style>

<footer class="ws-footer">
    <div class="ws-footer-grid">
        <div class="ws-footer-brand">
            <div class="ws-brand">
                <div class="ws-brand-mark"><i class="fa-solid fa-motorcycle"></i></div>
                <div>{{ $siteName }}<small>{{ $address }}</small></div>
            </div>
            <p>{{ $siteDescription }}</p>
        </div>

        <div>
            <div class="ws-footer-title">NAVIGASI</div>
            <div class="ws-footer-links">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('public.page', 'tentang') }}">Tentang Kami</a>
                <a href="{{ route('public.galleries') }}">Galeri</a>
                <a href="{{ route('public.blogs') }}">Blog</a>
                <a href="{{ route('public.faqs') }}">FAQ</a>
                <a href="{{ route('public.form.show', 'open-po-jaket') }}">Pesan Jaket</a>
            </div>
        </div>

        <div>
            <div class="ws-footer-title">KONTAK</div>
            <div class="ws-footer-links">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp Admin
                </a>
                <a href="https://instagram.com/{{ ltrim($instagram, '@') }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-instagram"></i> Instagram
                </a>
                <a href="mailto:{{ $contactEmail }}">
                    <i class="fa-solid fa-envelope"></i> {{ $contactEmail }}
                </a>
                <a href="#faq">FAQ</a>
            </div>
        </div>

        <div>
            <div class="ws-footer-title">SOSMED</div>
            <div class="ws-footer-links">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                </a>
                <a href="https://instagram.com/{{ ltrim($instagram, '@') }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-instagram"></i> Instagram
                </a>
            </div>
        </div>
    </div>

    <div class="ws-copyright">
        <span>© {{ date('Y') }} {{ $siteName }}. Semua hak cipta dilindungi.</span>
        <span>{{ $footerText }}</span>
    </div>
</footer>
