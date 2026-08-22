@php
    use Illuminate\Support\Facades\Storage;

    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';

    $seoTitle =
        $blog->seo_title
        ?: $blog->title . ' | ' . $siteName;

    $seoDescription =
        $blog->meta_description
        ?: ($blog->excerpt
            ?: \Illuminate\Support\Str::limit(
                strip_tags($blog->content),
                160
            ));

    $canonical =
        $blog->canonical_url
        ?? route(
            'public.blog.show',
            $blog->slug
        );

    $image = $blog->featured_image
        ? Storage::disk('public')->url(
            $blog->featured_image
        )
        : null;

    $readingTime = max(
        1,
        (int) ceil(
            str_word_count(
                strip_tags($blog->content)
            ) / 200
        )
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

@if($image)
<meta property="og:image"
      content="{{ $image }}">
@endif

<meta name="twitter:card"
      content="summary_large_image">

<link rel="preconnect"
      href="https://fonts.googleapis.com">

<link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@500;600;700;800;900&display=swap"
      rel="stylesheet">

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

:root{
    --red:#ef2029;
    --bg:#070709;
    --card:#0d0d10;
    --border:rgba(255,255,255,.09);
    --text:#f5f5f5;
    --muted:#96969f;
}

*{
    box-sizing:border-box;
}

body{
    margin:0;
    background:
        radial-gradient(
            circle at 50% -10%,
            rgba(239,32,41,.13),
            transparent 35%
        ),
        var(--bg);

    color:var(--text);

    font-family:Inter,Arial,sans-serif;
}

a{
    color:inherit;
    text-decoration:none;
}

.blog-container{
    width:min(980px,calc(100% - 32px));
    margin:auto;
    padding:90px 0 110px;
}

.blog-back{
    display:inline-flex;
    align-items:center;
    gap:8px;

    margin-bottom:28px;

    color:#ff4b52;

    font-size:12px;
    font-weight:700;
}

.blog-card{
    overflow:hidden;

    border:1px solid var(--border);
    border-radius:22px;

    background:rgba(255,255,255,.018);
}

.blog-head{
    padding:40px 42px 30px;
}

.blog-title{
    margin:0;

    font-family:Montserrat,Arial,sans-serif;

    font-size:clamp(35px,6vw,60px);
    line-height:1.08;

    font-weight:900;

    letter-spacing:-2px;
}

.blog-excerpt{
    margin:20px 0 0;

    color:var(--muted);

    font-size:15px;
    line-height:1.8;
}

.blog-meta{
    display:flex;
    flex-wrap:wrap;

    gap:15px;

    margin-top:22px;

    color:#777780;

    font-size:11px;
}

.blog-meta span{
    display:inline-flex;
    align-items:center;
    gap:7px;
}

.blog-meta i{
    color:var(--red);
}

.blog-image{
    width:100%;
    max-height:600px;

    display:block;

    object-fit:cover;
}

.blog-content{
    padding:40px 42px 50px;

    color:#d4d4d8;

    font-size:15px;
    line-height:1.9;

    overflow-wrap:anywhere;
}

.blog-content img{
    max-width:100%;
    height:auto;

    border-radius:14px;
}

.blog-content a{
    color:#ff4b52;
}

.blog-content h1,
.blog-content h2,
.blog-content h3,
.blog-content h4{
    margin-top:1.7em;

    color:#fff;

    font-family:Montserrat,Arial,sans-serif;
}

@media(max-width:650px){

    .blog-container{
        width:calc(100% - 28px);
        padding:55px 0 75px;
    }

    .blog-head{
        padding:27px 23px 23px;
    }

    .blog-content{
        padding:28px 23px 35px;
    }

    .blog-title{
        font-size:35px;
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

<div class="blog-container">

    <a
        href="{{ route('public.blogs') }}"
        class="blog-back"
    >
        <i class="fa-solid fa-arrow-left"></i>
        Kembali ke Blog
    </a>


    <article class="blog-card">


        @if(
            $blog->show_title ||
            $blog->show_excerpt ||
            $blog->show_date ||
            $blog->show_author ||
            $blog->show_reading_time
        )

        <header class="blog-head">


            @if($blog->show_title)

                <h1 class="blog-title">
                    {{ $blog->title }}
                </h1>

            @endif


            @if(
                $blog->show_excerpt &&
                $blog->excerpt
            )

                <p class="blog-excerpt">
                    {{ $blog->excerpt }}
                </p>

            @endif


            @if(
                $blog->show_date ||
                $blog->show_author ||
                $blog->show_reading_time
            )

                <div class="blog-meta">


                    @if(
                        $blog->show_date &&
                        $blog->published_at
                    )

                        <span>
                            <i class="fa-regular fa-calendar"></i>

                            {{ $blog->published_at->format('d M Y') }}
                        </span>

                    @endif


                    @if($blog->show_author)

                        <span>
                            <i class="fa-regular fa-user"></i>

                            {{ data_get($blog, 'author.name', 'Wacana Style') }}
                        </span>

                    @endif


                    @if($blog->show_reading_time)

                        <span>
                            <i class="fa-regular fa-clock"></i>

                            {{ $readingTime }} menit baca
                        </span>

                    @endif


                </div>

            @endif


        </header>

        @endif


        @if(
            $blog->show_thumbnail &&
            $image
        )

            <img
                src="{{ $image }}"
                alt="{{ $blog->title }}"
                class="blog-image"
            >

        @endif


        <div class="blog-content">

            {!! $blog->content !!}

        </div>


    </article>

</div>

</main>

@include('partials.footer')

</body>

</html>
