@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ | {{ $siteName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        *{box-sizing:border-box}
        body{
            width:100%;min-height:100%;margin:0;padding:0;overflow-x:hidden;
            background:#08080a;color:#f4f4f5;font-family:Inter,Arial,sans-serif;
        }
        h1,h2,h3,h4{font-family:Montserrat,Arial,sans-serif}
        a{color:inherit;text-decoration:none}
        img{max-width:100%}
        ::-webkit-scrollbar{width:6px}
        ::-webkit-scrollbar-track{background:#0d0d0f}
        ::-webkit-scrollbar-thumb{background:#dc2626;border-radius:10px}
        .container{width:min(1200px,calc(100% - 32px));margin:auto;padding:96px 0}
        .faq-item{
            overflow:hidden;
            border:1px solid rgba(255,255,255,.08);
            border-radius:12px;
            background:#111114;
        }
        .faq-question{
            width:100%;
            min-height:58px;
            display:flex;align-items:center;justify-content:space-between;gap:20px;
            padding:0 17px;
            color:#fff;
            background:transparent;
            border:0;
            cursor:pointer;
            text-align:left;
            font-size:12px;
            font-weight:800;
        }
        .faq-question i{color:#71717a;transition:.25s}
        .faq-question.open i{transform:rotate(180deg);color:#ef4444}
        .faq-answer{
            display:none;
            padding:0 17px 17px;
            color:#a1a1aa;
            font-size:11px;
            line-height:1.8;
        }
        .faq-answer.open{display:block}
    </style>
</head>
<body>

@include('partials.header-nav')

<div class="container">
    <h1 class="text-4xl font-bold mb-8">FAQ {{ $siteName }}</h1>
    <p class="text-slate-400 mb-8">Pertanyaan yang sering ditanyakan tentang Wacana Style</p>

    <div class="max-w-3xl mx-auto">
        <div class="faq-list">
            @forelse($faqs as $faq)
                <div class="faq-item">
                    <button class="faq-question" type="button" onclick="toggleFaq(this)">
                        {{ $faq->question }}
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        {!! $faq->answer !!}
                    </div>
                </div>
            @empty
                <div class="faq-item">
                    <button class="faq-question" type="button" onclick="toggleFaq(this)">
                        Belum ada FAQ tersedia
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        Silakan kembali lagi nanti.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

@include('partials.footer')

<script>
    function toggleFaq(button){
        const item = button.closest('.faq-item');
        const answer = item.querySelector('.faq-answer');
        const isOpen = answer.classList.contains('open');

        document.querySelectorAll('.faq-answer.open').forEach(el => el.classList.remove('open'));
        document.querySelectorAll('.faq-question.open').forEach(el => el.classList.remove('open'));

        if(!isOpen){
            answer.classList.add('open');
            button.classList.add('open');
        }
    }
</script>

</body>
</html>
