@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $gallery->title }} | {{ $siteName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100">
    <div class="max-w-6xl mx-auto py-16 px-4">
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
</body>
</html>
