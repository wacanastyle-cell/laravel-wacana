```blade
@php
    use Illuminate\Support\Facades\Storage;

    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Galeri | {{ $siteName }}</title>

    <meta name="description"
          content="Galeri foto kegiatan, perjalanan, event, dan dokumentasi {{ $siteName }}.">

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

        .gallery-hero {
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

        .gallery-hero h1 {
            margin: 0;

            font-size: clamp(40px, 6vw, 68px);
            line-height: 1.03;

            font-weight: 900;
            letter-spacing: -3px;
        }

        .gallery-hero h1 span {
            color: var(--red);
        }

        .gallery-subtitle {
            max-width: 650px;

            margin: 20px auto 0;

            color: var(--muted);

            font-size: 15px;
            line-height: 1.8;
        }

        .gallery-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            margin-top: 27px;

            color: var(--muted-dark);

            font-size: 12px;
        }

        .gallery-meta strong {
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
           GALLERY GRID
        ========================================= */

        .gallery-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 22px;

            margin-top: 58px;
        }

        /* =========================================
           GALLERY CARD
        ========================================= */

        .gallery-card {
            position: relative;

            display: block;

            overflow: hidden;

            min-width: 0;

            border: 1px solid var(--border);
            border-radius: 18px;

            background: var(--card);

            transition:
                transform .4s ease,
                border-color .4s ease,
                box-shadow .4s ease;
        }

        .gallery-card:hover {
            transform: translateY(-8px);

            border-color: rgba(239,32,41,.42);

            box-shadow:
                0 25px 60px rgba(0,0,0,.45),
                0 0 35px rgba(239,32,41,.07);
        }

        /* =========================================
           IMAGE
        ========================================= */

        .gallery-image {
            position: relative;

            width: 100%;
            height: 285px;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at center,
                    rgba(239,32,41,.13),
                    transparent 55%
                ),
                #111115;
        }

        .gallery-image img {
            display: block;

            width: 100%;
            height: 100%;

            object-fit: cover;

            transition:
                transform .8s cubic-bezier(.2,.7,.2,1),
                filter .5s ease;
        }

        .gallery-card:hover .gallery-image img {
            transform: scale(1.09);
            filter: brightness(.78);
        }

        /* =========================================
           IMAGE OVERLAY
        ========================================= */

        .gallery-overlay {
            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    to bottom,
                    rgba(0,0,0,.02) 15%,
                    rgba(0,0,0,.08) 45%,
                    rgba(0,0,0,.85) 100%
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
            font-size: 34px;
            color: #292930;
        }

        /* =========================================
           EVENT DATE
        ========================================= */

        .event-date {
            position: absolute;

            left: 18px;
            bottom: 18px;

            z-index: 3;

            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 8px 11px;

            border: 1px solid rgba(255,255,255,.13);
            border-radius: 8px;

            background: rgba(5,5,7,.72);

            backdrop-filter: blur(10px);

            color: #fff;

            font-size: 10px;
            font-weight: 700;

            letter-spacing: .4px;
        }

        .event-date i {
            color: #ff4b52;
        }

        /* =========================================
           OPEN ICON
        ========================================= */

        .gallery-open {
            position: absolute;

            top: 18px;
            right: 18px;

            z-index: 3;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 40px;
            height: 40px;

            border: 1px solid rgba(255,255,255,.13);
            border-radius: 10px;

            background: rgba(5,5,7,.65);

            backdrop-filter: blur(10px);

            color: #fff;

            font-size: 13px;

            opacity: 0;

            transform: translateY(-7px);

            transition: .35s ease;
        }

        .gallery-card:hover .gallery-open {
            opacity: 1;
            transform: translateY(0);
        }

        .gallery-open i {
            transition: .3s ease;
        }

        .gallery-card:hover .gallery-open i {
            color: var(--red);
        }

        /* =========================================
           CONTENT
        ========================================= */

        .gallery-content {
            padding: 23px 24px 22px;
        }

        .gallery-label {
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

        .gallery-label span {
            width: 18px;
            height: 2px;

            border-radius: 50px;

            background: var(--red);
        }

        .gallery-title {
            margin: 0;

            color: #fff;

            font-size: 19px;
            line-height: 1.4;

            font-weight: 800;

            letter-spacing: -.3px;

            transition: .3s ease;
        }

        .gallery-card:hover .gallery-title {
            color: #ff4b52;
        }

        .gallery-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-top: 19px;
            padding-top: 16px;

            border-top: 1px solid rgba(255,255,255,.07);

            color: #777780;

            font-size: 11px;
            font-weight: 600;
        }

        .gallery-view {
            display: flex;
            align-items: center;
            gap: 8px;

            color: #fff;

            font-size: 11px;
            font-weight: 800;
        }

        .gallery-view i {
            color: var(--red);

            transition: .3s ease;
        }

        .gallery-card:hover .gallery-view i {
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
           TABLET
        ========================================= */

        @media (max-width: 950px) {
            .gallery-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
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

            .gallery-hero h1 {
                font-size: 41px;
                letter-spacing: -2px;
            }

            .gallery-subtitle {
                font-size: 14px;
                line-height: 1.75;
            }

            .gallery-grid {
                grid-template-columns: 1fr;

                gap: 17px;

                margin-top: 40px;
            }

            .gallery-image {
                height: 250px;
            }

            .gallery-content {
                padding: 21px;
            }

            .gallery-title {
                font-size: 18px;
            }

            .gallery-open {
                opacity: 1;
                transform: none;
            }

            .empty-state {
                margin-top: 40px;
                padding: 50px 22px;
            }
        }

        @media (max-width: 400px) {
            .gallery-hero h1 {
                font-size: 35px;
            }

            .eyebrow {
                font-size: 9px;
                letter-spacing: 1.4px;
            }

            .gallery-meta {
                font-size: 11px;
            }

            .gallery-image {
                height: 225px;
            }
        }
    </style>
</head>

<body>

@include('partials.header-nav')

<main>

    <div class="container">

        <!-- =====================================
             HERO
        ====================================== -->

        <section class="gallery-hero">

            <div class="hero-line"></div>

            <div class="eyebrow">
                <i class="fa-solid fa-images"></i>
                Dokumentasi {{ $siteName }}
            </div>

            <h1>
                Galeri <span>Wacana</span>
            </h1>

            <p class="gallery-subtitle">
                Kumpulan dokumentasi kegiatan, perjalanan, event,
                dan momen-momen bersama {{ $siteName }}.
            </p>

            @if($galleries->count() > 0)

                <div class="gallery-meta">

                    <strong>{{ $galleries->count() }}</strong>
                    galeri tersedia

                    <span class="meta-dot"></span>

                    Lihat momen kami

                </div>

            @endif

        </section>


        <!-- =====================================
             GALLERY GRID
        ====================================== -->

        @if($galleries->count() > 0)

            <section class="gallery-grid">

                @foreach($galleries as $gallery)

                    <a
                        href="{{ route('public.gallery.detail', $gallery->slug) }}"
                        class="gallery-card"
                    >

                        <!-- IMAGE -->

                        <div class="gallery-image">

                            @if($gallery->cover)

                                <img
                                    src="{{ Storage::disk('public')->url($gallery->cover) }}"
                                    alt="{{ $gallery->title }}"
                                    loading="lazy"
                                >

                                <div class="gallery-overlay"></div>

                            @else

                                <div class="no-image">

                                    <div class="no-image-inner">

                                        <i class="fa-regular fa-images"></i>

                                        <span>
                                            Wacana Style
                                        </span>

                                    </div>

                                </div>

                            @endif


                            <!-- OPEN ICON -->

                            <div class="gallery-open">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </div>


                            <!-- EVENT DATE -->

                            <div class="event-date">

                                <i class="fa-regular fa-calendar"></i>

                                {{ $gallery->event_date
                                    ? $gallery->event_date->format('d M Y')
                                    : 'Dokumentasi'
                                }}

                            </div>

                        </div>


                        <!-- CONTENT -->

                        <div class="gallery-content">

                            <div class="gallery-label">

                                <span></span>

                                Galeri

                            </div>

                            <h2 class="gallery-title">
                                {{ $gallery->title }}
                            </h2>


                            <div class="gallery-bottom">

                                <span>
                                    Dokumentasi kegiatan
                                </span>

                                <div class="gallery-view">

                                    Lihat Galeri

                                    <i class="fa-solid fa-arrow-right"></i>

                                </div>

                            </div>

                        </div>

                    </a>

                @endforeach

            </section>

        @else

            <!-- =====================================
                 EMPTY STATE
            ====================================== -->

            <section class="empty-state">

                <div class="empty-icon">
                    <i class="fa-regular fa-images"></i>
                </div>

                <h3>
                    Belum Ada Galeri
                </h3>

                <p>
                    Belum ada galeri yang tersedia saat ini.
                    Silakan kembali lagi nanti untuk melihat
                    dokumentasi kegiatan terbaru dari {{ $siteName }}.
                </p>

            </section>

        @endif

    </div>

</main>

@include('partials.footer')

</body>
</html>
```
