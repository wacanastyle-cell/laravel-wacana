```blade
@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Formulir | {{ $siteName }}</title>

    <meta name="description" content="Daftar formulir {{ $siteName }}. Pilih formulir yang ingin Anda isi.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        :root {
            --red: #ef2029;
            --red-dark: #b91c1c;
            --red-soft: rgba(239, 32, 41, .12);
            --bg: #060608;
            --bg-card: #0c0c0f;
            --bg-card-2: #101014;
            --border: rgba(255,255,255,.09);
            --text: #f5f5f5;
            --muted: #92929b;
            --muted-2: #66666f;
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
                radial-gradient(circle at 50% -10%, rgba(239,32,41,.13), transparent 35%),
                var(--bg);
            color: var(--text);
            font-family: Inter, Arial, sans-serif;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: -1;
            background-image:
                linear-gradient(rgba(255,255,255,.018) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.018) 1px, transparent 1px);
            background-size: 45px 45px;
            mask-image: linear-gradient(to bottom, black, transparent 75%);
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

        /* =========================
           MAIN CONTAINER
        ========================= */

        .container {
            width: min(1180px, calc(100% - 36px));
            margin: auto;
            padding: 90px 0 110px;
        }

        /* =========================
           HERO
        ========================= */

        .forms-hero {
            position: relative;
            text-align: center;
            max-width: 780px;
            margin: 0 auto;
        }

        .hero-line {
            width: 58px;
            height: 4px;
            margin: 0 auto 22px;
            border-radius: 50px;
            background: var(--red);
            box-shadow: 0 0 22px rgba(239,32,41,.55);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            padding: 8px 14px;
            border: 1px solid rgba(239,32,41,.22);
            border-radius: 100px;
            background: rgba(239,32,41,.07);
            color: #ff4b52;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .eyebrow i {
            font-size: 10px;
        }

        .forms-hero h1 {
            margin: 0;
            font-size: clamp(38px, 6vw, 64px);
            line-height: 1.04;
            font-weight: 900;
            letter-spacing: -2.5px;
        }

        .forms-hero h1 span {
            color: var(--red);
        }

        .subtitle {
            max-width: 620px;
            margin: 20px auto 0;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.8;
        }

        /* =========================
           FORM COUNT
        ========================= */

        .form-count {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            margin-top: 28px;
            color: #777780;
            font-size: 13px;
        }

        .form-count strong {
            color: #fff;
            font-weight: 700;
        }

        .count-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--red);
            box-shadow: 0 0 10px rgba(239,32,41,.8);
        }

        /* =========================
           GRID
        ========================= */

        .forms-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-top: 58px;
        }

        /* =========================
           CARD
        ========================= */

        
        /* =========================
           FORM THUMBNAIL
        ========================= */

        .form-thumbnail {
            position: relative;
            width: calc(100% + 56px);
            margin: -28px -28px 24px;
            aspect-ratio: 16 / 9;
            overflow: hidden;
            background: #111114;
            border-bottom: 1px solid var(--border);
        }

        .form-thumbnail::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                transparent 45%,
                rgba(0,0,0,.45) 100%
            );
            pointer-events: none;
        }

        .form-thumbnail img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .45s ease;
        }

        .form-card:hover .form-thumbnail img {
            transform: scale(1.04);
        }

        .form-card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 270px;
            padding: 28px;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 18px;
            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.035),
                    rgba(255,255,255,.008)
                ),
                var(--bg-card);
            transition:
                transform .35s ease,
                border-color .35s ease,
                box-shadow .35s ease,
                background .35s ease;
        }

        .form-card::before {
            content: "";
            position: absolute;
            width: 170px;
            height: 170px;
            right: -90px;
            top: -90px;
            border-radius: 50%;
            background: rgba(239,32,41,.13);
            filter: blur(20px);
            opacity: .5;
            transition: .4s ease;
        }

        .form-card::after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(
                90deg,
                transparent,
                var(--red),
                transparent
            );
            opacity: 0;
            transition: .35s ease;
        }

        .form-card:hover {
            transform: translateY(-7px);
            border-color: rgba(239,32,41,.45);
            background:
                linear-gradient(
                    145deg,
                    rgba(239,32,41,.055),
                    rgba(255,255,255,.012)
                ),
                var(--bg-card-2);
            box-shadow:
                0 20px 50px rgba(0,0,0,.4),
                0 0 35px rgba(239,32,41,.08);
        }

        .form-card:hover::before {
            opacity: 1;
        }

        .form-card:hover::after {
            opacity: 1;
        }

        /* =========================
           ICON
        ========================= */

        .form-icon {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            margin-bottom: 23px;
            border: 1px solid rgba(239,32,41,.22);
            border-radius: 13px;
            background: rgba(239,32,41,.09);
            color: var(--red);
            font-size: 18px;
            transition: .35s ease;
        }

        .form-card:hover .form-icon {
            background: var(--red);
            color: #fff;
            border-color: var(--red);
            box-shadow: 0 8px 25px rgba(239,32,41,.25);
            transform: scale(1.05);
        }

        /* =========================
           CONTENT
        ========================= */

        .form-card-content {
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .form-card h3 {
            margin: 0 0 11px;
            color: #fff;
            font-size: 19px;
            line-height: 1.35;
            font-weight: 800;
            letter-spacing: -.3px;
        }

        .form-card p {
            margin: 0;
            color: var(--muted);
            font-size: 13.5px;
            line-height: 1.75;
        }

        /* =========================
           BUTTON
        ========================= */

        .form-card-footer {
            position: relative;
            z-index: 2;
            margin-top: 25px;
        }

        .form-card-link {
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            width: 100%;
            min-height: 46px;
            padding: 0 16px 0 18px;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 10px;
            background: rgba(255,255,255,.035);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            transition: .3s ease;
        }

        .form-card-link span {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .form-card-link i {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--red);
            color: #fff;
            font-size: 11px;
            transition: .3s ease;
        }

        .form-card:hover .form-card-link {
            border-color: rgba(239,32,41,.3);
            background: rgba(239,32,41,.08);
        }

        .form-card:hover .form-card-link i {
            transform: translateX(3px);
        }

        /* =========================
           EMPTY STATE
        ========================= */

        .empty-state {
            max-width: 650px;
            margin: 60px auto 0;
            padding: 65px 30px;
            text-align: center;
            border: 1px solid var(--border);
            border-radius: 20px;
            background: rgba(255,255,255,.018);
        }

        .empty-state-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            margin: 0 auto 24px;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px;
            background: rgba(255,255,255,.035);
            color: #55555e;
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

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 950px) {
            .forms-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 680px) {
            .container {
                width: min(100% - 28px, 560px);
                padding: 55px 0 75px;
            }

            .forms-hero h1 {
                font-size: 40px;
                letter-spacing: -1.8px;
            }

            .subtitle {
                font-size: 14px;
                line-height: 1.7;
            }

            .forms-grid {
                grid-template-columns: 1fr;
                gap: 15px;
                margin-top: 40px;
            }

            .form-card {
                min-height: 250px;
                padding: 23px;
                border-radius: 16px;
            }

            .form-card h3 {
                font-size: 18px;
            }

            .empty-state {
                margin-top: 40px;
                padding: 50px 22px;
            }
        }

        @media (max-width: 400px) {
            .forms-hero h1 {
                font-size: 34px;
            }

            .eyebrow {
                font-size: 9px;
                letter-spacing: 1.5px;
            }
        }
    </style>
</head>

<body>

    @include('partials.header-nav')

    <main>
        <div class="container">

            <!-- HERO -->
            <section class="forms-hero">

                <div class="hero-line"></div>

                <div class="eyebrow">
                    <i class="fa-solid fa-file-lines"></i>
                    Formulir {{ $siteName }}
                </div>

                <h1>
                    Pilih <span>Formulir</span>
                </h1>

                <p class="subtitle">
                    Silakan pilih formulir yang ingin Anda isi.
                    Pastikan seluruh informasi yang diberikan sudah benar
                    sebelum mengirimkan data.
                </p>

                @if($forms->count() > 0)
                    <div class="form-count">
                        <strong>{{ $forms->count() }}</strong>
                        formulir tersedia
                        <span class="count-dot"></span>
                        Siap diisi
                    </div>
                @endif

            </section>


            <!-- FORM LIST -->
            @if($forms->count() > 0)

                <section class="forms-grid">

                    @foreach($forms as $form)

                        <article class="form-card">
            @if(!empty($form->thumbnail))
                <div class="form-thumbnail">
                    <img
                        src="{{ asset('storage/' . ltrim($form->thumbnail, '/')) }}"
                        alt="{{ $form->title }}"
                        loading="lazy"
                        onerror="this.parentElement.style.display='none';"
                    >
                </div>
            @endif


                            <div class="form-icon">
                                <i class="fa-solid fa-file-pen"></i>
                            </div>

                            <div class="form-card-content">

                                <h3>
                                    {{ $form->title }}
                                </h3>

                                <p>
                                    {{ $form->description ?? 'Silakan isi formulir ini dengan data yang benar dan lengkap.' }}
                                </p>

                            </div>

                            <div class="form-card-footer">

                                <a
                                    href="{{ route('public.form.show', $form->slug) }}"
                                    class="form-card-link"
                                >
                                    <span>
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        Buka Formulir
                                    </span>

                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>

                            </div>

                        </article>

                    @endforeach

                </section>

            @else

                <!-- EMPTY STATE -->
                <section class="empty-state">

                    <div class="empty-state-icon">
                        <i class="fa-solid fa-inbox"></i>
                    </div>

                    <h3>
                        Belum Ada Formulir
                    </h3>

                    <p>
                        Mohon maaf, saat ini belum ada formulir yang tersedia
                        untuk diisi. Silakan kembali lagi nanti.
                    </p>

                </section>

            @endif

        </div>
    </main>

    @include('partials.footer')

</body>
</html>
```
