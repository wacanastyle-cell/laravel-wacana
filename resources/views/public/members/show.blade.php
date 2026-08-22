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
    <title>{{ $member->name }} | {{ $siteName }}</title>
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
    </style>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NGCRSJB2"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

@include('partials.header-nav')

<div class="container">
    <div class="mb-6">
        <a href="{{ route('public.members') }}" class="text-red-500 hover:text-red-400">← Kembali ke Daftar Anggota</a>
    </div>

    <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800">
        <div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold">{{ $member->name }}</h1>
                <p class="text-red-400 mt-2">{{ $member->member_number }}</p>
                <div class="mt-4 space-y-2 text-slate-300">
                    <p>Motor: {{ $member->motor_type ?? '-' }}</p>
                    <p>Kota: {{ $member->city ?? '-' }}</p>
                    @if($member->whatsapp)
                        <p>WhatsApp: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->whatsapp) }}" target="_blank" rel="noopener" class="text-red-400 hover:underline">{{ $member->whatsapp }}</a></p>
                    @endif
                    @if($member->instagram)
                        <p>Instagram: <a href="https://instagram.com/{{ ltrim($member->instagram, '@') }}" target="_blank" rel="noopener" class="text-red-400 hover:underline">{{ $member->instagram }}</a></p>
                    @endif
                </div>
            </div>
        </div>
        @if($member->bio)
            <div class="mt-8 text-slate-300">
                {!! nl2br(e($member->bio)) !!}
            </div>
        @endif
    </div>
</div>

@include('partials.footer')

</body>
</html>
