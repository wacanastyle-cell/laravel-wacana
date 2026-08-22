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
    <title>Anggota | {{ $siteName }}</title>
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
    <h1 class="text-4xl font-bold mb-8">Anggota {{ $siteName }}</h1>
    <div class="grid md:grid-cols-3 gap-6">
        @forelse($members as $member)
            <a href="{{ route('public.member.detail', $member->slug) }}" class="bg-slate-900 rounded-2xl p-4 border border-slate-800 hover:border-red-500 transition">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">{{ $member->name }}</h2>
                    <span class="px-2 py-1 rounded-full text-xs bg-emerald-500/20 text-emerald-300">{{ ucfirst($member->status) }}</span>
                </div>
                <p class="mt-2 text-slate-400">{{ $member->motor_type ?? '-' }}</p>
            </a>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-slate-400 text-lg">Belum ada anggota yang tersedia</p>
            </div>
        @endforelse
    </div>
</div>

@include('partials.footer')

</body>
</html>
