@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $siteName = $siteSettings['site_name'] ?? 'WacanaStyle';
    $seoTitle = 'Galeri | ' . $siteName;
    $seoDescription = 'Galeri foto kegiatan, perjalanan, event, dan dokumentasi ' . $siteName . '.';
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

    <title>{{ $seoTitle }}</title>

    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="index, follow">

    <link rel="canonical" href="{{ route('public.galleries') }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ route('public.galleries') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        :root {
            --red: #ef2029;
            --bg: #060608;
            --card: #0c0c0f;
            --border: rgba(255,255,255,.09);
            --text: #f5f5f5;
            --muted: #92929b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
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

        h1, h2, h3, h4 {
            font-family: Montserrat, Arial, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
        }

        .gallery-container {
            width: min(1180px, calc(100% - 36px));
            margin: auto;
            padding: 90px 0 110px;
        }

        .gallery-hero {
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
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 27px;
            color: #66666f;
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
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
            margin-top: 58px;
        }

        .gallery-card {
            display: block;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--card);
            transition: .35s ease;
        }

        .gallery-card:hover {
            transform: translateY(-8px);
            border-color: rgba(239,32,41,.42);
            box-shadow:
                0 25px 60px rgba(0,0,0,.45),
                0 0 35px rgba(239,32,41,.07);
        }

        .gallery-image {
            position: relative;
            width: 100%;
            height: 285px;
            overflow: hidden;
            background: #111115;
        }

        .gallery-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: .6s ease;
        }

        .gallery-card:hover .gallery-image img {
            transform: scale(1.07);
            filter: brightness(.8);
        }

        .no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #414149;
        }

        .no-image-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .no-image-inner i {
            font-size: 34px;
        }

        .featured-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            z-index: 3;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 8px;
            background: rgba(5,5,7,.75);
            color: #fff;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .featured-badge i {
            color: #facc15;
        }

        .event-date {
            position: absolute;
            bottom: 16px;
            left: 16px;
            z-index: 3;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 11px;
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 8px;
            background: rgba(5,5,7,.72);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
        }

        .event-date i {
            color: #ff4b52;
        }

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

        .gallery-title {
            margin: 0;
            font-size: 19px;
            line-height: 1.4;
            font-weight: 800;
        }

        .gallery-description {
            margin: 10px 0 0;
            color: #8c8c95;
            font-size: 12px;
            line-height: 1.65;
        }

        .gallery-info {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 14px;
            margin-top: 15px;
            color: #73737c;
            font-size: 10px;
        }

        .gallery-info span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .gallery-info i {
            color: var(--red);
        }

        .gallery-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
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
            font-weight: 800;
        }

        .gallery-view i {
            color: var(--red);
        }

        .empty-state {
            max-width: 650px;
            margin: 60px auto 0;
            padding: 65px 30px;
            text-align: center;
            border: 1px solid var(--border);
            border-radius: 20px;
            background: rgba(255,255,255,.018);
        }

        .empty-state i {
            font-size: 36px;
            color: #44444b;
        }

        .empty-state h3 {
            margin: 20px 0 10px;
        }

        .empty-state p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        @media (max-width: 950px) {
            .gallery-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 680px) {
            .gallery-container {
                width: min(100% - 28px, 560px);
                padding: 55px 0 75px;
            }

            .gallery-hero h1 {
                font-size: 41px;
                letter-spacing: -2px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 17px;
                margin-top: 40px;
            }

            .gallery-image {
                height: 250px;
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
    <div class="gallery-container">

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
                dan momen bersama {{ $siteName }}.
            </p>

            @if($galleries->count() > 0)
                <div class="gallery-meta">
                    <strong>{{ $galleries->count() }}</strong>
                    galeri tersedia

                    <span class="meta-dot"></span>

                    Lihat dokumentasi kami
                </div>
            @endif

        </section>

        @if($galleries->count() > 0)

            <section class="gallery-grid">

                @foreach($galleries as $gallery)

                    <a
                        href="{{ route('public.gallery.detail', ['slug' => $gallery->slug]) }}"
                        class="gallery-card"
                    >

                        <div class="gallery-image">

                            @if($gallery->cover)

                                <img
                                    src="{{ Storage::disk('public')->url($gallery->cover) }}"
                                    alt="{{ $gallery->title }}"
                                    loading="lazy"
                                >

                            @else

                                <div class="no-image">
                                    <div class="no-image-inner">
                                        <i class="fa-regular fa-images"></i>
                                        <span>Wacana Style</span>
                                    </div>
                                </div>

                            @endif

                            @if($gallery->featured)
                                <div class="featured-badge">
                                    <i class="fa-solid fa-star"></i>
                                    Unggulan
                                </div>
                            @endif

                            @if($gallery->show_date && $gallery->event_date)
                                <div class="event-date">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ $gallery->event_date->format('d M Y') }}
                                </div>
                            @endif

                        </div>

                        <div class="gallery-content">

                            @if($gallery->show_category && $gallery->category)
                                <div class="gallery-label">
                                    {{ $gallery->category }}
                                </div>
                            @endif

                            @if($gallery->show_title)
                                <h2 class="gallery-title">
                                    {{ $gallery->title }}
                                </h2>
                            @endif

                            @if($gallery->show_description && $gallery->description)
                                <p class="gallery-description">
                                    {{ Str::limit($gallery->description, 130) }}
                                </p>
                            @endif

                            <div class="gallery-info">

                                @if(
                                    $gallery->show_location &&
                                    ($gallery->location || $gallery->city)
                                )
                                    <span>
                                        <i class="fa-solid fa-location-dot"></i>

                                        {{ $gallery->city ?: $gallery->location }}
                                    </span>
                                @endif

                                <span>
                                    <i class="fa-regular fa-images"></i>
                                    {{ $gallery->photos_count }} foto
                                </span>

                                @if(
                                    $gallery->show_video &&
                                    $gallery->videos_count > 0
                                )
                                    <span>
                                        <i class="fa-solid fa-video"></i>
                                        {{ $gallery->videos_count }} video
                                    </span>
                                @endif

                            </div>

                            <div class="gallery-bottom">

                                <span>
                                    {{ $gallery->event_name ?: 'Dokumentasi kegiatan' }}
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

            <section class="empty-state">

                <i class="fa-regular fa-images"></i>

                <h3>Belum Ada Galeri</h3>

                <p>
                    Belum ada galeri yang dipublikasikan.
                    Dokumentasi terbaru akan muncul di halaman ini.
                </p>

            </section>

        @endif

    </div>
</main>

@include('partials.footer')

</body>
</html>
