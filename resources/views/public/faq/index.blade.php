@php
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

    <title>FAQ | {{ $siteName }}</title>

    <meta name="description"
          content="Pertanyaan yang sering ditanyakan tentang {{ $siteName }}. Temukan informasi dan jawaban seputar Wacana Style.">

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
            --card-hover: #101014;

            --border: rgba(255,255,255,.08);
            --border-hover: rgba(239,32,41,.35);

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

        /* GRID BACKGROUND */

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

        button {
            font-family: inherit;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        ::selection {
            background: var(--red);
            color: #fff;
        }

        /* SCROLLBAR */

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

        .faq-hero {
            max-width: 780px;

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

        .faq-hero h1 {
            margin: 0;

            color: #fff;

            font-size: clamp(40px, 6vw, 68px);

            line-height: 1.03;

            font-weight: 900;

            letter-spacing: -3px;
        }

        .faq-hero h1 span {
            color: var(--red);
        }

        .faq-subtitle {
            max-width: 620px;

            margin: 20px auto 0;

            color: var(--muted);

            font-size: 15px;

            line-height: 1.8;
        }

        .faq-meta {
            display: flex;

            align-items: center;
            justify-content: center;

            gap: 10px;

            margin-top: 27px;

            color: var(--muted-dark);

            font-size: 12px;
        }

        .faq-meta strong {
            color: #fff;
        }

        .meta-dot {
            width: 5px;
            height: 5px;

            border-radius: 50%;

            background: var(--red);

            box-shadow:
                0 0 10px rgba(239,32,41,.8);
        }

        /* =========================================
           FAQ WRAPPER
        ========================================= */

        .faq-wrapper {
            width: min(850px, 100%);

            margin: 55px auto 0;
        }

        .faq-list {
            display: flex;

            flex-direction: column;

            gap: 11px;
        }

        /* =========================================
           FAQ ITEM
        ========================================= */

        .faq-item {
            position: relative;

            overflow: hidden;

            border: 1px solid var(--border);

            border-radius: 15px;

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.035),
                    rgba(255,255,255,.008)
                ),
                var(--card);

            transition:
                border-color .35s ease,
                background .35s ease,
                box-shadow .35s ease,
                transform .35s ease;
        }

        .faq-item:hover {
            border-color: rgba(255,255,255,.14);

            background: var(--card-hover);
        }

        .faq-item.active {
            border-color: var(--border-hover);

            background:
                linear-gradient(
                    145deg,
                    rgba(239,32,41,.055),
                    rgba(255,255,255,.01)
                ),
                var(--card);

            box-shadow:
                0 12px 35px rgba(0,0,0,.28),
                0 0 30px rgba(239,32,41,.035);
        }

        /* =========================================
           FAQ TOP RED LINE
        ========================================= */

        .faq-item::before {
            content: "";

            position: absolute;

            top: 0;
            left: 0;

            width: 0;
            height: 2px;

            background: var(--red);

            transition: width .4s ease;
        }

        .faq-item.active::before {
            width: 100%;
        }

        /* =========================================
           QUESTION
        ========================================= */

        .faq-question {
            position: relative;

            display: flex;

            align-items: center;

            width: 100%;

            min-height: 76px;

            padding: 15px 20px;

            border: 0;

            background: transparent;

            color: #fff;

            text-align: left;

            cursor: pointer;

            transition: .3s ease;
        }

        .faq-question:focus-visible {
            outline: 2px solid var(--red);

            outline-offset: -2px;
        }

        /* NUMBER */

        .faq-number {
            flex: 0 0 auto;

            display: flex;

            align-items: center;
            justify-content: center;

            width: 37px;
            height: 37px;

            margin-right: 15px;

            border: 1px solid rgba(255,255,255,.08);

            border-radius: 10px;

            background: rgba(255,255,255,.025);

            color: #66666f;

            font-family: Montserrat, sans-serif;

            font-size: 10px;

            font-weight: 800;

            transition:
                background .3s ease,
                border-color .3s ease,
                color .3s ease;
        }

        .faq-item.active .faq-number {
            border-color: rgba(239,32,41,.3);

            background: rgba(239,32,41,.1);

            color: #ff4b52;
        }

        /* QUESTION TEXT */

        .faq-question-text {
            flex: 1;

            padding-right: 12px;

            color: #e9e9eb;

            font-size: 13px;

            line-height: 1.5;

            font-weight: 750;

            transition: color .3s ease;
        }

        .faq-item.active .faq-question-text {
            color: #fff;
        }

        /* ARROW */

        .faq-arrow {
            flex: 0 0 auto;

            display: flex;

            align-items: center;
            justify-content: center;

            width: 34px;
            height: 34px;

            border: 1px solid rgba(255,255,255,.07);

            border-radius: 9px;

            background: rgba(255,255,255,.025);

            color: #66666f;

            font-size: 11px;

            transition:
                transform .4s cubic-bezier(.2,.7,.2,1),
                background .3s ease,
                border-color .3s ease,
                color .3s ease;
        }

        .faq-item.active .faq-arrow {
            transform: rotate(180deg);

            border-color: rgba(239,32,41,.3);

            background: rgba(239,32,41,.1);

            color: var(--red);
        }

        /* =========================================
           ANSWER
        ========================================= */

        .faq-answer-wrap {
            display: grid;

            grid-template-rows: 0fr;

            transition:
                grid-template-rows .4s
                cubic-bezier(.2,.7,.2,1);
        }

        .faq-item.active .faq-answer-wrap {
            grid-template-rows: 1fr;
        }

        .faq-answer-inner {
            overflow: hidden;
        }

        .faq-answer {
            padding: 0 20px 0 72px;

            color: var(--muted);

            font-size: 13px;

            line-height: 1.85;

            opacity: 0;

            transform: translateY(-5px);

            transition:
                opacity .3s ease,
                transform .4s ease,
                padding .4s ease;
        }

        .faq-item.active .faq-answer {
            padding-bottom: 22px;

            opacity: 1;

            transform: translateY(0);
        }

        /* CONTENT INSIDE ANSWER */

        .faq-answer p {
            margin-top: 0;
        }

        .faq-answer p:last-child {
            margin-bottom: 0;
        }

        .faq-answer a {
            color: #ff4b52;

            text-decoration: underline;

            text-underline-offset: 3px;
        }

        .faq-answer strong {
            color: #fff;
        }

        .faq-answer ul,
        .faq-answer ol {
            padding-left: 20px;
        }

        /* =========================================
           EMPTY STATE
        ========================================= */

        .empty-state {
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
           BOTTOM HELP
        ========================================= */

        .faq-help {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-top: 30px;

            padding: 22px 24px;

            border: 1px solid rgba(255,255,255,.07);

            border-radius: 15px;

            background:
                linear-gradient(
                    100deg,
                    rgba(239,32,41,.055),
                    rgba(255,255,255,.015)
                );
        }

        .help-left {
            display: flex;

            align-items: center;

            gap: 14px;
        }

        .help-icon {
            display: flex;

            align-items: center;
            justify-content: center;

            flex: 0 0 auto;

            width: 40px;
            height: 40px;

            border-radius: 10px;

            background: rgba(239,32,41,.1);

            color: var(--red);

            font-size: 14px;
        }

        .help-text strong {
            display: block;

            margin-bottom: 3px;

            color: #fff;

            font-family: Montserrat, sans-serif;

            font-size: 12px;

            font-weight: 800;
        }

        .help-text span {
            color: var(--muted);

            font-size: 11px;
        }

        .help-button {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 10px 14px;

            border: 1px solid rgba(239,32,41,.25);

            border-radius: 9px;

            background: rgba(239,32,41,.08);

            color: #ff4b52;

            font-size: 11px;

            font-weight: 800;

            transition: .3s ease;
        }

        .help-button:hover {
            background: var(--red);

            border-color: var(--red);

            color: #fff;

            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(239,32,41,.2);
        }

        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 680px) {

            .container {
                width: min(100% - 28px, 560px);

                padding: 55px 0 75px;
            }

            .faq-hero h1 {
                font-size: 41px;

                letter-spacing: -2px;
            }

            .faq-subtitle {
                font-size: 14px;

                line-height: 1.75;
            }

            .faq-wrapper {
                margin-top: 40px;
            }

            .faq-question {
                min-height: 70px;

                padding: 13px 14px;
            }

            .faq-number {
                width: 32px;
                height: 32px;

                margin-right: 11px;

                border-radius: 8px;

                font-size: 9px;
            }

            .faq-question-text {
                font-size: 12px;
            }

            .faq-arrow {
                width: 31px;
                height: 31px;

                border-radius: 8px;

                font-size: 10px;
            }

            .faq-answer {
                padding-left: 57px;
                padding-right: 17px;

                font-size: 12px;

                line-height: 1.8;
            }

            .faq-item.active .faq-answer {
                padding-bottom: 18px;
            }

            .faq-help {
                align-items: flex-start;

                flex-direction: column;

                padding: 19px;
            }

            .help-button {
                width: 100%;

                justify-content: center;
            }
        }

        @media (max-width: 400px) {

            .faq-hero h1 {
                font-size: 35px;
            }

            .eyebrow {
                font-size: 9px;

                letter-spacing: 1.4px;
            }

            .faq-meta {
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
             HERO
        ====================================== -->

        <section class="faq-hero">

            <div class="hero-line"></div>

            <div class="eyebrow">
                <i class="fa-solid fa-circle-question"></i>
                Pusat Informasi
            </div>

            <h1>
                FAQ <span>{{ $siteName }}</span>
            </h1>

            <p class="faq-subtitle">
                Temukan jawaban dari berbagai pertanyaan yang
                sering ditanyakan tentang {{ $siteName }}.
            </p>

            @if($faqs->count() > 0)

                <div class="faq-meta">

                    <strong>{{ $faqs->count() }}</strong>
                    pertanyaan tersedia

                    <span class="meta-dot"></span>

                    Temukan jawaban dengan cepat

                </div>

            @endif

        </section>


        <!-- =====================================
             FAQ
        ====================================== -->

        <div class="faq-wrapper">

            @if($faqs->count() > 0)

                <div class="faq-list">

                    @foreach($faqs as $index => $faq)

                        <div class="faq-item">

                            <button
                                class="faq-question"
                                type="button"
                                onclick="toggleFaq(this)"
                                aria-expanded="false"
                            >

                                <span class="faq-number">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                <span class="faq-question-text">
                                    {{ $faq->question }}
                                </span>

                                <span class="faq-arrow">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>

                            </button>


                            <div class="faq-answer-wrap">

                                <div class="faq-answer-inner">

                                    <div class="faq-answer">

                                        {!! $faq->answer !!}

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>


                <!-- =================================
                     HELP BOX
                ================================== -->

                <div class="faq-help">

                    <div class="help-left">

                        <div class="help-icon">
                            <i class="fa-regular fa-comments"></i>
                        </div>

                        <div class="help-text">

                            <strong>
                                Masih punya pertanyaan?
                            </strong>

                            <span>
                                Hubungi kami untuk mendapatkan informasi lebih lanjut.
                            </span>

                        </div>

                    </div>

                    <a href="{{ url('/page/kontak') }}" class="help-button">

                        Hubungi Kami

                        <i class="fa-solid fa-arrow-right"></i>

                    </a>

                </div>

            @else

                <!-- =================================
                     EMPTY STATE
                ================================== -->

                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="fa-regular fa-circle-question"></i>
                    </div>

                    <h3>
                        Belum Ada FAQ
                    </h3>

                    <p>
                        Belum ada pertanyaan yang tersedia saat ini.
                        Silakan kembali lagi nanti untuk mendapatkan
                        informasi terbaru dari {{ $siteName }}.
                    </p>

                </div>

            @endif

        </div>

    </div>

</main>

@include('partials.footer')


<script>
    function toggleFaq(button) {

        const item = button.closest('.faq-item');

        const isOpen = item.classList.contains('active');

        /*
         * Tutup semua FAQ lainnya
         */
        document
            .querySelectorAll('.faq-item.active')
            .forEach(function (faq) {

                faq.classList.remove('active');

                const faqButton =
                    faq.querySelector('.faq-question');

                if (faqButton) {
                    faqButton.setAttribute(
                        'aria-expanded',
                        'false'
                    );
                }
            });


        /*
         * Jika sebelumnya belum terbuka,
         * buka FAQ yang diklik
         */
        if (!isOpen) {

            item.classList.add('active');

            button.setAttribute(
                'aria-expanded',
                'true'
            );

        }

    }
</script>

</body>
</html>