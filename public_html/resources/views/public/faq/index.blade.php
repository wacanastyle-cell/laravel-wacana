@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ | {{ $siteName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100">
    <div class="max-w-4xl mx-auto py-16 px-4">
        <h1 class="text-4xl font-bold mb-8">FAQ {{ $siteName }}</h1>
        <div class="space-y-4">
            @foreach($faqs as $faq)
                <div class="bg-slate-900 rounded-xl p-5 border border-slate-800">
                    <h2 class="text-xl font-semibold">{{ $faq->question }}</h2>
                    <p class="mt-3 text-slate-300">{{ $faq->answer }}</p>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
