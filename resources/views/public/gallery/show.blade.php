@php
    use Illuminate\Support\Facades\Storage;
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $gallery->title }} | {{ $siteName }}</title>
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
    <div class="mb-6">
        <a href="{{ route('public.galleries') }}" class="text-red-500 hover:text-red-400">← Kembali ke Galeri</a>
    </div>

    <h1 class="text-4xl font-bold mb-4">{{ $gallery->title }}</h1>
    @if($gallery->description)
        <p class="text-slate-300 mb-8">{{ $gallery->description }}</p>
    @endif

    <div class="grid md:grid-cols-3 gap-6">
        @foreach($gallery->photos as $photo)
            <div class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-800">
                <img src="{{ Storage::disk('public')->url($photo->image) }}" alt="{{ $photo->caption ?? $gallery->title }}" class="h-64 w-full object-cover">
                @if($photo->caption)
                    <p class="p-3 text-sm text-slate-300">{{ $photo->caption }}</p>
                @endif
            </div>
        @endforeach
    </div>
</div>

@include('partials.footer')

</body>
</html>
