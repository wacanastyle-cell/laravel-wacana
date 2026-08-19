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

@include('partials.header-nav')

<div class="container">
    <h1 class="text-4xl font-bold mb-8">Galeri {{ $siteName }}</h1>
    <div class="grid md:grid-cols-3 gap-6">
        @forelse($galleries as $gallery)
            <a href="{{ route('public.gallery.detail', $gallery->slug) }}" class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-800 hover:border-red-500 transition group">
                @if($gallery->cover)
                    <img src="{{ Storage::disk('public')->url($gallery->cover) }}" alt="{{ $gallery->title }}" class="h-56 w-full object-cover group-hover:scale-105 transition">
                @else
                    <div class="h-56 w-full bg-slate-800 flex items-center justify-center">
                        <span class="text-slate-600">No Image</span>
                    </div>
                @endif
                <div class="p-4">
                    <h2 class="text-xl font-semibold">{{ $gallery->title }}</h2>
                    <p class="text-sm text-slate-400 mt-2">{{ $gallery->event_date ? $gallery->event_date->format('d M Y') : '-' }}</p>
                </div>
            </a>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-slate-400 text-lg">Belum ada galeri yang tersedia</p>
            </div>
        @endforelse
    </div>
</div>

@include('partials.footer')

</body>
</html>
