@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri | {{ $siteName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100">
    <div class="max-w-6xl mx-auto py-16 px-4">
        <h1 class="text-4xl font-bold mb-8">Galeri {{ $siteName }}</h1>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($galleries as $gallery)
                <a href="{{ route('public.gallery.detail', $gallery->slug) }}" class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-800 hover:border-red-500 transition">
                    @if($gallery->cover)
                        <img src="{{ Storage::disk('public')->url($gallery->cover) }}" alt="{{ $gallery->title }}" class="h-56 w-full object-cover">
                    @endif
                    <div class="p-4">
                        <h2 class="text-xl font-semibold">{{ $gallery->title }}</h2>
                        <p class="text-sm text-slate-400 mt-2">{{ $gallery->event_date ? $gallery->event_date->format('d M Y') : '-' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>
