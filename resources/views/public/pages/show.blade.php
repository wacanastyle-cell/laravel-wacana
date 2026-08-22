@php
    use Illuminate\Support\Facades\Storage;

    $siteName = $siteSettings['site_name'] ?? 'WacanaStyle';

    $seoTitle = $page->seo_title
        ?: $page->title . ' | ' . $siteName;

    $seoDescription = $page->meta_description
        ?: ($page->excerpt
            ?: 'Halaman ' . $page->title . ' - ' . $siteName);

    $canonical = $page->canonical_url
        ?: route('public.page', ['slug' => $page->slug]);

    $ogImage = null;

    if ($page->og_image) {
        $ogImage = Storage::disk('public')->url($page->og_image);
    } elseif ($page->featured_image) {
        $ogImage = Storage::disk('public')->url($page->featured_image);
    }

    $isBlank = $page->template === 'blank';
    $isFullWidth = $page->template === 'full-width';

    $wrapperClass = trim(
        'page-public ' .
        ($page->custom_css_class ?? '')
    );
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

    @if($page->meta_keywords)
        <meta name="keywords"
              content="{{ $page->meta_keywords }}">
    @endif

    @if($page->seo_index)
        <meta name="robots"
              content="index, follow">
    @else
        <meta name="robots"
              content="noindex, nofollow">
    @endif

    <link rel="canonical"
          href="{{ $canonical }}">

    <meta property="og:type"
          content="website">

    <meta property="og:title"
          content="{{ $seoTitle }}">

    <meta property="og:description"
          content="{{ $seoDescription }}">

    <meta property="og:url"
          content="{{ $canonical }}">

    @if($ogImage)
        <meta property="og:image"
              content="{{ $ogImage }}">
    @endif

    <meta name="twitter:card"
          content="summary_large_image">

    <meta name="twitter:title"
          content="{{ $seoTitle }}">

    <meta name="twitter:description"
          content="{{ $seoDescription }}">

    @if($ogImage)
        <meta name="twitter:image"
              content="{{ $ogImage }}">
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
            --bg: #060608;
            --card: #0c0c0f;
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
            padding: 0;
            overflow-x: hidden;

            background:
                radial-gradient(
                    circle at 50% -8%,
                    rgba(239,32,41,.12),
                    transparent 35%
                ),
                var(--bg);

            color: var(--text);

            font-family:
                Inter,
                Arial,
                sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family:
                Montserrat,
                Arial,
                sans-serif;
        }

        a {
            color: inherit;
        }

        img {
            max-width: 100%;
        }

        .page-wrapper {
            width:
                min(
                    1180px,
                    calc(100% - 36px)
                );

            margin: auto;

            padding:
                75px 0 100px;
        }

        .page-wrapper.full-width {
            width: calc(100% - 36px);
            max-width: none;
        }

        .page-wrapper.blank {
            width: 100%;
            max-width: none;
            padding: 0;
        }

        .page-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;

            margin-bottom: 25px;

            color: #777780;

            font-size: 11px;
        }

        .page-breadcrumb a {
            color: #ff4b52;
            text-decoration: none;
        }

        .page-breadcrumb i {
            font-size: 8px;
        }

        .page-shell {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr);

            gap: 28px;
        }

        .page-shell.with-sidebar {
            grid-template-columns:
                minmax(0, 1fr)
                300px;
        }

        .page-main {
            min-width: 0;
        }

        .page-card {
            overflow: hidden;

            border:
                1px solid var(--border);

            border-radius: 22px;

            background:
                rgba(255,255,255,.018);
        }

        .blank .page-card {
            border: 0;
            border-radius: 0;
            background: transparent;
        }

        .page-hero {
            padding:
                38px 42px 28px;
        }

        .blank .page-hero {
            padding: 0;
        }

        .page-title {
            margin: 0;

            font-size:
                clamp(
                    32px,
                    5vw,
                    58px
                );

            line-height: 1.08;

            font-weight: 900;

            letter-spacing: -2px;
        }

        .page-excerpt {
            max-width: 850px;

            margin:
                18px 0 0;

            color: #a1a1aa;

            font-size: 15px;

            line-height: 1.8;
        }

        .page-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 14px;

            margin-top: 18px;

            color: #777780;

            font-size: 10px;
        }

        .page-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .page-meta i {
            color: var(--red);
        }

        .featured-image {
            width: 100%;
            max-height: 600px;

            object-fit: cover;

            display: block;
        }

        .page-content {
            padding:
                38px 42px 48px;

            color: #d0d0d5;

            font-size: 15px;

            line-height: 1.85;

            overflow-wrap: anywhere;
        }

        .blank .page-content {
            padding: 0;
        }

        .page-content h1,
        .page-content h2,
        .page-content h3,
        .page-content h4 {
            margin:
                1.6em 0 .7em;

            color: #fff;
        }

        .page-content p {
            margin:
                0 0 1.25em;
        }

        .page-content a {
            color: #ff4b52;
        }

        .page-content img {
            height: auto;

            border-radius: 15px;
        }

        .page-content table {
            display: block;

            width: 100%;

            overflow-x: auto;

            border-collapse: collapse;
        }

        .page-content th,
        .page-content td {
            padding: 10px;

            border:
                1px solid rgba(255,255,255,.1);
        }

        .page-content blockquote {
            margin:
                25px 0;

            padding:
                18px 22px;

            border-left:
                4px solid var(--red);

            background:
                rgba(255,255,255,.025);
        }

        .sidebar {
            align-self: start;

            padding: 24px;

            border:
                1px solid var(--border);

            border-radius: 18px;

            background:
                rgba(255,255,255,.018);
        }

        .sidebar h3 {
            margin:
                0 0 16px;

            font-size: 15px;
        }

        .sidebar-item {
            padding:
                10px 0;

            border-bottom:
                1px solid rgba(255,255,255,.06);

            color: #92929b;

            font-size: 11px;
        }

        .sidebar-item:last-child {
            border-bottom: 0;
        }

        .sidebar-item strong {
            display: block;

            margin-top: 4px;

            color: #eee;

            font-size: 12px;
        }

        @media (max-width: 900px) {

            .page-shell.with-sidebar {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 650px) {

            .page-wrapper {
                width:
                    min(
                        100% - 28px,
                        560px
                    );

                padding:
                    50px 0 70px;
            }

            .page-wrapper.full-width {
                width:
                    calc(
                        100% - 28px
                    );
            }

            .page-wrapper.blank {
                width: 100%;
                padding: 0;
            }

            .page-hero {
                padding:
                    26px 24px 20px;
            }

            .page-content {
                padding:
                    25px 24px 32px;
            }

            .page-title {
                font-size: 34px;
            }

            .blank .page-content,
            .blank .page-hero {
                padding: 0;
            }

        }
    </style>

</head>


<body class="{{ $wrapperClass }}">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NGCRSJB2"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


@if(
    !$isBlank &&
    $page->show_header
)

    @include('partials.header-nav')

@endif


<main>

    <div
        class="
            page-wrapper
            {{ $isFullWidth ? 'full-width' : '' }}
            {{ $isBlank ? 'blank' : '' }}
        "
    >


        @if(
            !$isBlank &&
            $page->show_breadcrumb
        )

            <nav
                class="page-breadcrumb"
                aria-label="Breadcrumb"
            >

                <a href="{{ route('home') }}">
                    Beranda
                </a>

                @if($page->parent)

                    <i class="fa-solid fa-chevron-right"></i>

                    <a
                        href="{{ route(
                            'public.page',
                            ['slug' => $page->parent->slug]
                        ) }}"
                    >
                        {{ $page->parent->title }}
                    </a>

                @endif

                <i class="fa-solid fa-chevron-right"></i>

                <span>
                    {{ $page->title }}
                </span>

            </nav>

        @endif


        <div
            class="
                page-shell
                {{
                    (!$isBlank && $page->show_sidebar)
                        ? 'with-sidebar'
                        : ''
                }}
            "
        >

            <div class="page-main">

                <article class="page-card">


                    @if(
                        !$isBlank &&
                        (
                            $page->show_title ||
                            $page->show_excerpt ||
                            $page->show_published_date
                        )
                    )

                        <header class="page-hero">


                            @if($page->show_title)

                                <h1 class="page-title">

                                    {{ $page->title }}

                                </h1>

                            @endif


                            @if(
                                $page->show_excerpt &&
                                $page->excerpt
                            )

                                <p class="page-excerpt">

                                    {{ $page->excerpt }}

                                </p>

                            @endif


                            @if(
                                $page->show_published_date &&
                                $page->published_at
                            )

                                <div class="page-meta">

                                    <span>

                                        <i class="fa-regular fa-calendar"></i>

                                        {{ $page->published_at->format('d M Y') }}

                                    </span>

                                </div>

                            @endif


                        </header>

                    @endif


                    @if(
                        !$isBlank &&
                        $page->show_featured_image &&
                        $page->featured_image
                    )

                        <img
                            src="{{ Storage::disk('public')->url($page->featured_image) }}"
                            alt="{{ $page->title }}"
                            class="featured-image"
                        >

                    @endif


                    <div class="page-content">

                        {!! $page->content !!}

                    </div>


                </article>

            </div>


            @if(
                !$isBlank &&
                $page->show_sidebar
            )

                <aside class="sidebar">

                    <h3>
                        Informasi Halaman
                    </h3>


                    @if($page->parent)

                        <div class="sidebar-item">

                            Halaman Induk

                            <strong>
                                {{ $page->parent->title }}
                            </strong>

                        </div>

                    @endif


                    @if($page->published_at)

                        <div class="sidebar-item">

                            Dipublikasikan

                            <strong>
                                {{ $page->published_at->format('d M Y') }}
                            </strong>

                        </div>

                    @endif


                    @if($page->comments_enabled)

                        <div class="sidebar-item">

                            Komentar

                            <strong>
                                Diaktifkan
                            </strong>

                        </div>

                    @endif


                    @if(
                        is_array($page->custom_fields) &&
                        count($page->custom_fields)
                    )

                        @foreach($page->custom_fields as $key => $value)

                            <div class="sidebar-item">

                                {{ $key }}

                                <strong>
                                    {{ is_scalar($value) ? $value : '' }}
                                </strong>

                            </div>

                        @endforeach

                    @endif

                </aside>

            @endif


        </div>

    </div>

</main>


@if(
    !$isBlank &&
    $page->show_footer
)

    @include('partials.footer')

@endif


</body>

</html>
