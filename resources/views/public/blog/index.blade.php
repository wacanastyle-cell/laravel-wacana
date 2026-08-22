```blade
@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('storage/icon-logo/icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/icon-logo/icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/icon-logo/icon.png') }}">
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":
    new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src=
    "https://www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,"script","dataLayer","GTM-NGCRSJB2");</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Blog | {{ $siteName }}</title>

    <meta name="description"
          content="Artikel, cerita, berita, dan informasi terbaru dari {{ $siteName }}.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        :root {
            --red: #ef2029;
            --red-dark: #b91c1c;
            --bg: #060608;
            --card: #0c0c0f;
            --card-2: #101014;
            --border: rgba(255,255,255,.09);
            --text: #f5f5f5;
            --muted: #92929b;
            --muted-dark: #66666f;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            width: 100%;
            min-height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;

            background:
                radial-gradient(
                    circle at 50% -8%,
                    rgba(239,32,41,.15),
                    transparent 35%
                ),
                var(--bg);

            color: var(--text);
            font-family: Inter, Arial, sans-serif;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;

            background-image:
                linear-gradient(
                    rgba(255,255,255,.017) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(255,255,255,.017) 1px,
                    transparent 1px
                );

            background-size: 45px 45px;

            mask-image:
                linear-gradient(
                    to bottom,
                    black,
                    transparent 75%
                );
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: Montserrat, Arial, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
        }

        ::selection {
            background: var(--red);
            color: #fff;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0a0c;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--red);
            border-radius: 20px;
        }

        /* =========================================
           CONTAINER
        ========================================= */

        .container {
            width: min(1180px, calc(100% - 36px));
            margin: auto;
            padding: 90px 0 110px;
        }

        /* =========================================
           HERO
        ========================================= */

        .blog-hero {
            position: relative;
            max-width: 820px;
            margin: 0 auto;
            text-align: center;
        }

        .hero-line {
            width: 58px;
            height: 4px;
            margin: 0 auto 22px;

            border-radius: 50px;
            background: var(--red);

            box-shadow:
                0 0 12px rgba(239,32,41,.6),
                0 0 30px rgba(239,32,41,.2);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;

            margin-bottom: 17px;
            padding: 8px 14px;

            border: 1px solid rgba(239,32,41,.22);
            border-radius: 100px;

            background: rgba(239,32,41,.07);

            color: #ff4b52;

            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .eyebrow i {
            font-size: 10px;
        }

        .blog-hero h1 {
            margin: 0;

            font-size: clamp(40px, 6vw, 68px);
            line-height: 1.03;

            font-weight: 900;
            letter-spacing: -3px;
        }

        .blog-hero h1 span {
            color: var(--red);
        }

        .blog-subtitle {
            max-width: 650px;
            margin: 20px auto 0;

            color: var(--muted);

            font-size: 15px;
            line-height: 1.8;
        }

        .blog-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            margin-top: 27px;

            color: var(--muted-dark);
            font-size: 12px;
        }

        .blog-meta strong {
            color: #fff;
        }

        .meta-dot {
            width: 5px;
            height: 5px;

            border-radius: 50%;
            background: var(--red);

            box-shadow: 0 0 10px rgba(239,32,41,.8);
        }

        /* =========================================
           BLOG GRID
        ========================================= */

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;

            margin-top: 58px;
        }

        /* =========================================
           BLOG CARD
        ========================================= */

        .blog-card {
            position: relative;

            display: flex;
            flex-direction: column;

            min-width: 0;

            overflow: hidden;

            border: 1px solid var(--border);
            border-radius: 18px;

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.035),
                    rgba(255,255,255,.008)
                ),
                var(--card);

            transition:
                transform .4s ease,
                border-color .4s ease,
                box-shadow .4s ease;
        }

        .blog-card:hover {
            transform: translateY(-8px);

            border-color: rgba(239,32,41,.42);

            box-shadow:
                0 25px 60px rgba(0,0,0,.45),
                0 0 35px rgba(239,32,41,.07);
        }

        /* =========================================
           IMAGE
        ========================================= */

        .blog-image {
            position: relative;

            height: 245px;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at center,
                    rgba(239,32,41,.12),
                    transparent 60%
                ),
                #111115;
        }

        .blog-image img {
            display: block;

            width: 100%;
            height: 100%;

            object-fit: cover;

            transition:
                transform .7s cubic-bezier(.2,.7,.2,1),
                filter .5s ease;
        }

        .blog-card:hover .blog-image img {
            transform: scale(1.08);
            filter: brightness(.85);
        }

        .image-overlay {
            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    to bottom,
                    rgba(0,0,0,.05) 20%,
                    rgba(0,0,0,.15) 50%,
                    rgba(0,0,0,.75) 100%
                );

            pointer-events: none;
        }

        /* =========================================
           NO IMAGE
        ========================================= */

        .no-image {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 100%;
            height: 100%;

            background:
                radial-gradient(
                    circle at center,
                    rgba(239,32,41,.12),
                    transparent 45%
                ),
                #0d0d10;

            color: #414149;
        }

        .no-image-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;

            font-size: 12px;
            font-weight: 600;
        }

        .no-image-inner i {
            font-size: 30px;
            color: #292930;
        }

        /* =========================================
           DATE BADGE
        ========================================= */

        .blog-date {
            position: absolute;
            left: 18px;
            bottom: 17px;
            z-index: 3;

            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 7px 11px;

            border: 1px solid rgba(255,255,255,.13);
            border-radius: 8px;

            background: rgba(5,5,7,.72);
            backdrop-filter: blur(10px);

            color: #fff;

            font-size: 10px;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .blog-date i {
            color: #ff4b52;
        }

        /* =========================================
           CARD CONTENT
        ========================================= */

        .blog-content {
            display: flex;
            flex-direction: column;
            flex: 1;

            padding: 24px 24px 22px;
        }

        .blog-label {
            display: flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 11px;

            color: #ff4b52;

            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .blog-label span {
            width: 18px;
            height: 2px;

            border-radius: 50px;
            background: var(--red);
        }

        .blog-title {
            margin: 0;

            color: #fff;

            font-size: 19px;
            line-height: 1.38;

            font-weight: 800;
            letter-spacing: -.35px;
        }

        .blog-excerpt {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;

            margin: 13px 0 0;

            color: var(--muted);

            font-size: 13px;
            line-height: 1.75;
        }

        /* =========================================
           READ BUTTON
        ========================================= */

        .blog-read {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-top: 22px;
            padding-top: 17px;

            border-top: 1px solid rgba(255,255,255,.07);

            color: #fff;

            font-size: 12px;
            font-weight: 800;

            transition: .3s ease;
        }

        .blog-read-text {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .blog-read-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 30px;
            height: 30px;

            border-radius: 8px;

            background: rgba(239,32,41,.1);
            color: var(--red);

            transition: .3s ease;
        }

        .blog-read-arrow {
            color: #55555e;

            transition: .3s ease;
        }

        .blog-card:hover .blog-read-icon {
            background: var(--red);
            color: #fff;

            box-shadow:
                0 5px 18px rgba(239,32,41,.25);
        }

        .blog-card:hover .blog-read-arrow {
            color: var(--red);
            transform: translateX(4px);
        }

        /* =========================================
           EMPTY STATE
        ========================================= */

        .empty-state {
            max-width: 650px;

            margin: 60px auto 0;
            padding: 65px 30px;

            text-align: center;

            border: 1px solid var(--border);
            border-radius: 20px;

            background: rgba(255,255,255,.018);
        }

        .empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 74px;
            height: 74px;

            margin: 0 auto 24px;

            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px;

            background: rgba(255,255,255,.035);

            color: #50505a;

            font-size: 27px;
        }

        .empty-state h3 {
            margin: 0 0 10px;

            color: #fff;

            font-size: 21px;
            font-weight: 800;
        }

        .empty-state p {
            margin: 0;

            color: var(--muted);

            font-size: 14px;
            line-height: 1.7;
        }

        /* =========================================
           PAGINATION
        ========================================= */

        .pagination-wrap {
            display: flex;
            justify-content: center;

            margin-top: 55px;
        }

        .pagination-wrap nav {
            display: flex;
            justify-content: center;
        }

        .pagination-wrap svg {
            width: 16px;
            height: 16px;
        }

        .pagination-wrap nav > div:first-child {
            display: none;
        }

        .pagination-wrap nav > div:last-child {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pagination-wrap span,
        .pagination-wrap a {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;

            min-width: 38px;
            height: 38px;
            padding: 0 12px;

            border: 1px solid rgba(255,255,255,.08) !important;
            border-radius: 9px;

            background: rgba(255,255,255,.025) !important;

            color: #888891 !important;

            font-size: 12px;
            font-weight: 700;

            transition: .25s ease;
        }

        .pagination-wrap a:hover {
            border-color: rgba(239,32,41,.35) !important;
            background: rgba(239,32,41,.08) !important;
            color: #fff !important;
        }

        .pagination-wrap span[aria-current="page"] {
            border-color: var(--red) !important;
            background: var(--red) !important;
            color: #fff !important;
            box-shadow: 0 5px 20px rgba(239,32,41,.2);
        }

        /* =========================================
           TABLET
        ========================================= */

        @media (max-width: 950px) {
            .blog-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 680px) {
            .container {
                width: min(100% - 28px, 560px);
                padding: 55px 0 75px;
            }

            .blog-hero h1 {
                font-size: 41px;
                letter-spacing: -2px;
            }

            .blog-subtitle {
                font-size: 14px;
                line-height: 1.75;
            }

            .blog-grid {
                grid-template-columns: 1fr;
                gap: 17px;
                margin-top: 40px;
            }

            .blog-image {
                height: 225px;
            }

            .blog-content {
                padding: 21px;
            }

            .blog-title {
                font-size: 18px;
            }

            .pagination-wrap {
                margin-top: 40px;
            }
        }

        @media (max-width: 400px) {
            .blog-hero h1 {
                font-size: 35px;
            }

            .eyebrow {
                font-size: 9px;
                letter-spacing: 1.4px;
            }

            .blog-meta {
                font-size: 11px;
            }
        }
    </style>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NGCRSJB2"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

@include('partials.header-nav')

<main>

    <div class="container">

        <!-- =====================================
             BLOG HERO
        ====================================== -->

        <section class="blog-hero">

            <div class="hero-line"></div>

            <div class="eyebrow">
                <i class="fa-solid fa-newspaper"></i>
                Wacana Style Blog
            </div>

            <h1>
                Cerita & <span>Wacana</span>
            </h1>

            <p class="blog-subtitle">
                Artikel, cerita perjalanan, kegiatan komunitas,
                informasi terbaru, dan berbagai hal menarik dari
                {{ $siteName }}.
            </p>

            @if($blogs->count() > 0)
                <div class="blog-meta">
                    <strong>{{ $blogs->total() }}</strong>
                    artikel tersedia

                    <span class="meta-dot"></span>

                    Temukan cerita terbaru kami
                </div>
            @endif

        </section>


        <!-- =====================================
             BLOG LIST
        ====================================== -->

        @if($blogs->count() > 0)

            <section class="blog-grid">

                @foreach($blogs as $blog)

                    <a
                        href="{{ route('public.blog.show', $blog->slug) }}"
                        class="blog-card"
                    >

                        <!-- IMAGE -->

                        <div class="blog-image">

                            @if($blog->featured_image)

                                <img
                                    src="{{ url('/storage/' . ltrim($blog->featured_image, '/')) }}"
                                    alt="{{ $blog->title }}"
                                    loading="lazy"
                                >

                                <div class="image-overlay"></div>

                            @else

                                <div class="no-image">

                                    <div class="no-image-inner">

                                        <i class="fa-regular fa-image"></i>

                                        <span>
                                            Wacana Style
                                        </span>

                                    </div>

                                </div>

                            @endif


                            <!-- DATE -->

                            <div class="blog-date">

                                <i class="fa-regular fa-calendar"></i>

                                {{ $blog->published_at->format('d M Y') }}

                            </div>

                        </div>


                        <!-- CONTENT -->

                        <div class="blog-content">

                            <div class="blog-label">

                                <span></span>

                                Artikel

                            </div>

                            <h2 class="blog-title">
                                {{ $blog->title }}
                            </h2>

                            <p class="blog-excerpt">
                                {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}
                            </p>


                            <!-- READ -->

                            <div class="blog-read">

                                <div class="blog-read-text">

                                    <span class="blog-read-icon">
                                        <i class="fa-solid fa-book-open"></i>
                                    </span>

                                    Baca Selengkapnya

                                </div>

                                <i class="fa-solid fa-arrow-right blog-read-arrow"></i>

                            </div>

                        </div>

                    </a>

                @endforeach

            </section>


            <!-- =====================================
                 PAGINATION
            ====================================== -->

            @if($blogs->hasPages())

                <div class="pagination-wrap">
                    {{ $blogs->links() }}
                </div>

            @endif


        @else

            <!-- =====================================
                 EMPTY STATE
            ====================================== -->

            <section class="empty-state">

                <div class="empty-icon">
                    <i class="fa-regular fa-newspaper"></i>
                </div>

                <h3>
                    Belum Ada Artikel
                </h3>

                <p>
                    Belum ada artikel yang dipublikasikan.
                    Silakan kembali lagi nanti untuk membaca
                    cerita dan informasi terbaru dari {{ $siteName }}.
                </p>

            </section>

        @endif

    </div>

</main>

@include('partials.footer')

</body>
</html>
```
