@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }} | {{ $siteName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100">
    <div class="max-w-4xl mx-auto py-16 px-4">
        <h1 class="text-4xl font-bold mb-6">{{ $page->title }}</h1>
        @if($page->featured_image)
            <img src="{{ Storage::disk('public')->url($page->featured_image) }}" alt="{{ $page->title }}" class="w-full rounded-2xl mb-8">
        @endif
        <article class="prose prose-invert max-w-none prose-headings:text-white prose-p:text-slate-300">
            {!! $page->content !!}
        </article>
    </div>
</body>
</html>
