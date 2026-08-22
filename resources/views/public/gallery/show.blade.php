@php
    use Illuminate\Support\Facades\Storage;

    $siteName = $siteSettings['site_name'] ?? 'WacanaStyle';

    $seoTitle = $gallery->seo_title
        ?: $gallery->title . ' | ' . $siteName;

    $seoDescription = $gallery->meta_description
        ?: ($gallery->description
            ?: 'Dokumentasi ' . $gallery->title . ' dari ' . $siteName . '.');

    $canonical = $gallery->canonical_url
        ?: route('public.gallery.detail', ['slug' => $gallery->slug]);

    $seoImage = null;

    if ($gallery->seo_image) {
        $seoImage = Storage::disk('public')->url($gallery->seo_image);
    } elseif ($gallery->cover) {
        $seoImage = Storage::disk('public')->url($gallery->cover);
    }
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

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $seoTitle }}</title>

    <meta name="description"
          content="{{ $seoDescription }}">

    <meta name="robots"
          content="index, follow">

    <link rel="canonical"
          href="{{ $canonical }}">

    <meta property="og:type"
          content="article">

    <meta property="og:title"
          content="{{ $seoTitle }}">

    <meta property="og:description"
          content="{{ $seoDescription }}">

    <meta property="og:url"
          content="{{ $canonical }}">

    @if($seoImage)
        <meta property="og:image"
              content="{{ $seoImage }}">
    @endif

    <meta name="twitter:card"
          content="summary_large_image">

    <meta name="twitter:title"
          content="{{ $seoTitle }}">

    <meta name="twitter:description"
          content="{{ $seoDescription }}">

    @if($seoImage)
        <meta name="twitter:image"
              content="{{ $seoImage }}">
    @endif

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

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
            --card-soft: #101014;

            --border: rgba(255,255,255,.09);

            --text: #f5f5f5;
            --muted: #92929b;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;

            overflow-x: hidden;

            background:
                radial-gradient(
                    circle at 50% -8%,
                    rgba(239,32,41,.14),
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

        .gallery-container {
            width: min(1200px, calc(100% - 32px));
            margin: auto;

            padding: 90px 0 110px;
        }

        /* BACK */

        .back-link {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 30px;

            color: #ff4b52;

            font-size: 12px;
            font-weight: 700;

            transition: .25s ease;
        }

        .back-link:hover {
            color: #fff;
        }

        /* HERO */

        .hero {
            display: grid;

            grid-template-columns:
                minmax(0, 1.2fr)
                minmax(320px, .8fr);

            gap: 25px;

            align-items: stretch;
        }

        .hero-content,
        .hero-cover {
            overflow: hidden;

            border: 1px solid var(--border);

            border-radius: 22px;

            background:
                rgba(255,255,255,.018);
        }

        .hero-content {
            padding: 42px;
        }

        .featured {
            display: inline-flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 12px;

            color: #facc15;

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 1.5px;

            text-transform: uppercase;
        }

        .category {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 18px;

            padding: 8px 13px;

            border:
                1px solid rgba(239,32,41,.22);

            border-radius: 100px;

            background:
                rgba(239,32,41,.07);

            color: #ff4b52;

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 1.4px;

            text-transform: uppercase;
        }

        .hero-title {
            margin: 0;

            max-width: 800px;

            font-size:
                clamp(35px, 5vw, 58px);

            line-height: 1.08;

            font-weight: 900;

            letter-spacing: -2px;
        }

        .hero-description {
            max-width: 760px;

            margin: 20px 0 0;

            color: #a1a1aa;

            font-size: 14px;

            line-height: 1.85;
        }

        .hero-cover {
            min-height: 380px;

            background: #111115;
        }

        .hero-cover img {
            display: block;

            width: 100%;
            height: 100%;

            object-fit: cover;
        }

        .hero-cover-empty {
            display: flex;

            align-items: center;

            justify-content: center;

            flex-direction: column;

            gap: 12px;

            width: 100%;
            height: 100%;
            min-height: 380px;

            color: #3f3f46;
        }

        .hero-cover-empty i {
            font-size: 45px;
        }

        /* EVENT INFO */

        .event-box {
            margin-top: 25px;

            padding: 28px;

            border: 1px solid var(--border);

            border-radius: 20px;

            background:
                rgba(255,255,255,.018);
        }

        .event-header {
            display: flex;

            align-items: center;

            gap: 10px;

            margin-bottom: 20px;
        }

        .event-header i {
            color: var(--red);
        }

        .event-header h2 {
            margin: 0;

            font-size: 17px;

            font-weight: 900;
        }

        .event-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 0 35px;
        }

        .info-item {
            display: flex;

            align-items: flex-start;

            gap: 12px;

            padding: 15px 0;

            border-bottom:
                1px solid rgba(255,255,255,.06);
        }

        .info-icon {
            display: flex;

            align-items: center;

            justify-content: center;

            flex: 0 0 34px;

            width: 34px;
            height: 34px;

            border-radius: 9px;

            background:
                rgba(239,32,41,.08);

            color: #ff4b52;

            font-size: 12px;
        }

        .info-content small {
            display: block;

            margin-bottom: 4px;

            color: #66666f;

            font-size: 9px;

            font-weight: 800;

            letter-spacing: 1px;

            text-transform: uppercase;
        }

        .info-content strong {
            color: #eee;

            font-size: 12px;

            line-height: 1.5;
        }

        .event-description {
            margin-top: 22px;

            padding-top: 20px;

            border-top:
                1px solid rgba(255,255,255,.07);

            color: #96969f;

            font-size: 13px;

            line-height: 1.8;

            white-space: pre-line;
        }

        /* SECTION */

        .section {
            margin-top: 52px;
        }

        .section-heading {
            display: flex;

            align-items: end;

            justify-content: space-between;

            gap: 16px;

            margin-bottom: 22px;
        }

        .section-heading h2 {
            margin: 0;

            font-size: 25px;

            font-weight: 900;
        }

        .section-heading span {
            color: #66666f;

            font-size: 11px;
        }

        /* PHOTO */

        .photo-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 18px;
        }

        .photo-card {
            overflow: hidden;

            border: 1px solid var(--border);

            border-radius: 17px;

            background: var(--card);
        }

        .photo-image {
            position: relative;

            height: 280px;

            overflow: hidden;

            background: #111115;

            cursor: pointer;
        }

        .photo-image img {
            display: block;

            width: 100%;
            height: 100%;

            object-fit: cover;

            transition:
                transform .55s ease,
                filter .35s ease;
        }

        .photo-card:hover .photo-image img {
            transform: scale(1.06);

            filter: brightness(.8);
        }

        .photo-zoom {
            position: absolute;

            inset: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            opacity: 0;

            transition: .3s ease;

            pointer-events: none;
        }

        .photo-card:hover .photo-zoom {
            opacity: 1;
        }

        .photo-zoom span {
            display: flex;

            align-items: center;

            justify-content: center;

            width: 48px;
            height: 48px;

            border-radius: 50%;

            background:
                rgba(239,32,41,.9);

            color: #fff;
        }

        .photo-content {
            padding: 15px 16px;
        }

        .photo-title {
            display: block;

            margin-bottom: 5px;

            color: #eee;

            font-size: 12px;

            font-weight: 800;
        }

        .photo-caption {
            color: #8b8b95;

            font-size: 11px;

            line-height: 1.65;
        }

        /* VIDEO */

        .video-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 20px;
        }

        .video-card {
            overflow: hidden;

            border: 1px solid var(--border);

            border-radius: 17px;

            background: var(--card);
        }

        .video-frame {
            position: relative;

            width: 100%;

            aspect-ratio: 16 / 9;

            background: #000;
        }

        .video-frame iframe,
        .video-frame video {
            display: block;

            width: 100%;
            height: 100%;

            border: 0;
        }

        .video-thumb {
            position: relative;

            width: 100%;
            height: 100%;
        }

        .video-thumb img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }

        .video-play {
            position: absolute;

            inset: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                rgba(0,0,0,.28);
        }

        .video-play span {
            display: flex;

            align-items: center;

            justify-content: center;

            width: 60px;
            height: 60px;

            border-radius: 50%;

            background: var(--red);

            color: #fff;

            font-size: 18px;

            box-shadow:
                0 12px 30px rgba(0,0,0,.45);
        }

        .video-content {
            padding: 18px;
        }

        .video-content h3 {
            margin: 0;

            font-size: 15px;

            font-weight: 800;
        }

        .video-content p {
            margin: 8px 0 0;

            color: #85858f;

            font-size: 11px;

            line-height: 1.7;
        }

        /* EMPTY */

        .empty-state {
            padding: 50px 25px;

            text-align: center;

            border: 1px solid var(--border);

            border-radius: 18px;

            background:
                rgba(255,255,255,.015);

            color: #777780;

            font-size: 13px;
        }

        .empty-state i {
            display: block;

            margin-bottom: 12px;

            color: #44444b;

            font-size: 30px;
        }

        /* LIGHTBOX */

        .lightbox {
            position: fixed;

            inset: 0;

            z-index: 99999;

            display: none;

            align-items: center;

            justify-content: center;

            padding: 25px;

            background:
                rgba(0,0,0,.94);
        }

        .lightbox.active {
            display: flex;
        }

        .lightbox-image {
            display: block;

            max-width: min(1200px, 95vw);
            max-height: 85vh;

            border-radius: 12px;

            object-fit: contain;
        }

        .lightbox-close {
            position: absolute;

            top: 20px;
            right: 20px;

            display: flex;

            align-items: center;

            justify-content: center;

            width: 44px;
            height: 44px;

            border: 1px solid rgba(255,255,255,.15);

            border-radius: 50%;

            background: #111;

            color: #fff;

            cursor: pointer;

            font-size: 17px;
        }

        .lightbox-caption {
            position: absolute;

            left: 50%;
            bottom: 20px;

            transform: translateX(-50%);

            max-width: 700px;

            padding: 10px 16px;

            border-radius: 10px;

            background:
                rgba(0,0,0,.65);

            color: #ddd;

            font-size: 12px;

            text-align: center;
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {

            .hero {
                grid-template-columns: 1fr;
            }

            .hero-cover {
                min-height: 300px;
            }

            .event-grid {
                grid-template-columns: 1fr;
            }

            .photo-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

        }

        @media (max-width: 650px) {

            .gallery-container {
                width: min(100% - 28px, 560px);

                padding: 55px 0 75px;
            }

            .hero-content {
                padding: 25px;
            }

            .hero-title {
                font-size: 35px;
            }

            .hero-cover,
            .hero-cover-empty {
                min-height: 240px;
            }

            .event-box {
                padding: 22px;
            }

            .photo-grid,
            .video-grid {
                grid-template-columns: 1fr;
            }

            .photo-image {
                height: 250px;
            }

            .section-heading {
                align-items: flex-start;

                flex-direction: column;

                gap: 6px;
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

        <a
            href="{{ route('public.galleries') }}"
            class="back-link"
        >
            <i class="fa-solid fa-arrow-left"></i>

            Kembali ke Galeri
        </a>


        <section class="hero">

            <div class="hero-content">

                @if($gallery->featured)

                    <div class="featured">

                        <i class="fa-solid fa-star"></i>

                        Galeri Unggulan

                    </div>

                @endif


                @if(
                    $gallery->show_category &&
                    $gallery->category
                )

                    <div class="category">

                        <i class="fa-solid fa-tag"></i>

                        {{ $gallery->category }}

                    </div>

                @endif


                @if($gallery->show_title)

                    <h1 class="hero-title">

                        {{ $gallery->title }}

                    </h1>

                @endif


                @if(
                    $gallery->show_description &&
                    $gallery->description
                )

                    <p class="hero-description">

                        {{ $gallery->description }}

                    </p>

                @endif

            </div>


            @if($gallery->cover)

                <div class="hero-cover">

                    <img
                        src="{{ Storage::disk('public')->url($gallery->cover) }}"
                        alt="{{ $gallery->title }}"
                    >

                </div>

            @else

                <div class="hero-cover">

                    <div class="hero-cover-empty">

                        <i class="fa-regular fa-images"></i>

                        <span>Wacana Style</span>

                    </div>

                </div>

            @endif

        </section>


        @if(
            $gallery->event_name ||
            ($gallery->show_date && $gallery->event_date) ||
            ($gallery->show_location && ($gallery->location || $gallery->city)) ||
            $gallery->organizer ||
            $gallery->event_description
        )

            <section class="event-box">

                <div class="event-header">

                    <i class="fa-solid fa-calendar-days"></i>

                    <h2>Informasi Event</h2>

                </div>


                <div class="event-grid">

                    @if($gallery->event_name)

                        <div class="info-item">

                            <div class="info-icon">

                                <i class="fa-solid fa-flag"></i>

                            </div>

                            <div class="info-content">

                                <small>Nama Event</small>

                                <strong>
                                    {{ $gallery->event_name }}
                                </strong>

                            </div>

                        </div>

                    @endif


                    @if(
                        $gallery->show_date &&
                        $gallery->event_date
                    )

                        <div class="info-item">

                            <div class="info-icon">

                                <i class="fa-regular fa-calendar"></i>

                            </div>

                            <div class="info-content">

                                <small>Tanggal Event</small>

                                <strong>
                                    {{ $gallery->event_date->format('d M Y') }}
                                </strong>

                            </div>

                        </div>

                    @endif


                    @if(
                        $gallery->show_location &&
                        $gallery->location
                    )

                        <div class="info-item">

                            <div class="info-icon">

                                <i class="fa-solid fa-location-dot"></i>

                            </div>

                            <div class="info-content">

                                <small>Lokasi</small>

                                <strong>
                                    {{ $gallery->location }}
                                </strong>

                            </div>

                        </div>

                    @endif


                    @if(
                        $gallery->show_location &&
                        $gallery->city
                    )

                        <div class="info-item">

                            <div class="info-icon">

                                <i class="fa-solid fa-city"></i>

                            </div>

                            <div class="info-content">

                                <small>Kota / Kabupaten</small>

                                <strong>
                                    {{ $gallery->city }}
                                </strong>

                            </div>

                        </div>

                    @endif


                    @if($gallery->organizer)

                        <div class="info-item">

                            <div class="info-icon">

                                <i class="fa-solid fa-users"></i>

                            </div>

                            <div class="info-content">

                                <small>Penyelenggara</small>

                                <strong>
                                    {{ $gallery->organizer }}
                                </strong>

                            </div>

                        </div>

                    @endif

                </div>


                @if($gallery->event_description)

                    <div class="event-description">

                        {{ $gallery->event_description }}

                    </div>

                @endif

            </section>

        @endif


        <section class="section">

            <div class="section-heading">

                <h2>
                    Dokumentasi Foto
                </h2>

                <span>
                    {{ $gallery->photos->count() }} foto
                </span>

            </div>


            @if($gallery->photos->count() > 0)

                <div class="photo-grid">

                    @foreach($gallery->photos as $photo)

                        <article class="photo-card">

                            <div
                                class="photo-image"
                                data-lightbox-image="{{ Storage::disk('public')->url($photo->image) }}"
                                data-lightbox-caption="{{ $photo->caption ?: $photo->title ?: $gallery->title }}"
                            >

                                <img
                                    src="{{ Storage::disk('public')->url($photo->image) }}"
                                    alt="{{ $photo->alt_text ?: $photo->caption ?: $photo->title ?: $gallery->title }}"
                                    loading="lazy"
                                >

                                <div class="photo-zoom">

                                    <span>

                                        <i class="fa-solid fa-magnifying-glass-plus"></i>

                                    </span>

                                </div>

                            </div>


                            @if(
                                $photo->title ||
                                $photo->caption
                            )

                                <div class="photo-content">

                                    @if($photo->title)

                                        <span class="photo-title">

                                            {{ $photo->title }}

                                        </span>

                                    @endif


                                    @if($photo->caption)

                                        <div class="photo-caption">

                                            {{ $photo->caption }}

                                        </div>

                                    @endif

                                </div>

                            @endif

                        </article>

                    @endforeach

                </div>

            @else

                <div class="empty-state">

                    <i class="fa-regular fa-images"></i>

                    Belum ada foto dalam galeri ini.

                </div>

            @endif

        </section>


        @if(
            $gallery->show_video &&
            $gallery->videos->count() > 0
        )

            <section class="section">

                <div class="section-heading">

                    <h2>
                        Video
                    </h2>

                    <span>
                        {{ $gallery->videos->count() }} video
                    </span>

                </div>


                <div class="video-grid">

                    @foreach($gallery->videos as $video)

                        @php
                            $youtubeId = null;

                            if ($video->youtube_url) {

                                preg_match(
                                    '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/shorts\/)([^&?\/]+)/',
                                    $video->youtube_url,
                                    $matches
                                );

                                $youtubeId = $matches[1] ?? null;
                            }
                        @endphp


                        <article class="video-card">

                            @if($youtubeId)

                                <div class="video-frame">

                                    <iframe
                                        src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                        title="{{ $video->title ?: $gallery->title }}"
                                        loading="lazy"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen
                                    ></iframe>

                                </div>

                            @elseif($video->external_url)

                                <div class="video-frame">

                                    <video
                                        controls
                                        preload="metadata"

                                        @if($video->thumbnail)
                                            poster="{{ Storage::disk('public')->url($video->thumbnail) }}"
                                        @endif
                                    >

                                        <source
                                            src="{{ $video->external_url }}"
                                        >

                                        Browser Anda tidak mendukung video HTML5.

                                    </video>

                                </div>

                            @elseif($video->thumbnail)

                                <div class="video-frame">

                                    <div class="video-thumb">

                                        <img
                                            src="{{ Storage::disk('public')->url($video->thumbnail) }}"
                                            alt="{{ $video->title ?: $gallery->title }}"
                                        >

                                        <div class="video-play">

                                            <span>

                                                <i class="fa-solid fa-play"></i>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            @endif


                            @if(
                                $video->title ||
                                $video->description
                            )

                                <div class="video-content">

                                    @if($video->title)

                                        <h3>
                                            {{ $video->title }}
                                        </h3>

                                    @endif


                                    @if($video->description)

                                        <p>
                                            {{ $video->description }}
                                        </p>

                                    @endif

                                </div>

                            @endif

                        </article>

                    @endforeach

                </div>

            </section>

        @endif

    </div>

</main>


<div
    id="gallery-lightbox"
    class="lightbox"
>

    <button
        type="button"
        class="lightbox-close"
        id="gallery-lightbox-close"
        aria-label="Tutup"
    >

        <i class="fa-solid fa-xmark"></i>

    </button>

    <img
        src=""
        alt=""
        class="lightbox-image"
        id="gallery-lightbox-image"
    >

    <div
        class="lightbox-caption"
        id="gallery-lightbox-caption"
    ></div>

</div>


@include('partials.footer')


<script>
document.addEventListener('DOMContentLoaded', function () {

    const lightbox =
        document.getElementById('gallery-lightbox');

    const lightboxImage =
        document.getElementById('gallery-lightbox-image');

    const lightboxCaption =
        document.getElementById('gallery-lightbox-caption');

    const closeButton =
        document.getElementById('gallery-lightbox-close');


    document
        .querySelectorAll('[data-lightbox-image]')
        .forEach(function (item) {

            item.addEventListener('click', function () {

                lightboxImage.src =
                    item.dataset.lightboxImage;

                lightboxImage.alt =
                    item.dataset.lightboxCaption || '';

                lightboxCaption.textContent =
                    item.dataset.lightboxCaption || '';

                lightbox.classList.add('active');

                document.body.style.overflow =
                    'hidden';

            });

        });


    function closeLightbox() {

        lightbox.classList.remove('active');

        lightboxImage.src = '';

        document.body.style.overflow = '';

    }


    closeButton.addEventListener(
        'click',
        closeLightbox
    );


    lightbox.addEventListener(
        'click',
        function (event) {

            if (event.target === lightbox) {
                closeLightbox();
            }

        }
    );


    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                lightbox.classList.contains('active')
            ) {
                closeLightbox();
            }

        }
    );

});
</script>

</body>

</html>
