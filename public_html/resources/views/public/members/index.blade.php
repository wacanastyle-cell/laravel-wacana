@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member | {{ $siteName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100">
    <div class="max-w-6xl mx-auto py-16 px-4">
        <h1 class="text-4xl font-bold mb-8">Member {{ $siteName }}</h1>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($members as $member)
                <a href="{{ route('public.member.detail', $member->slug) }}" class="bg-slate-900 rounded-2xl p-4 border border-slate-800 hover:border-red-500 transition">
                    @if($member->photo)
                        <img src="{{ Storage::disk('public')->url($member->photo) }}" alt="{{ $member->name }}" class="h-56 w-full object-cover rounded-xl mb-4">
                    @endif
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold">{{ $member->name }}</h2>
                        <span class="px-2 py-1 rounded-full text-xs bg-emerald-500/20 text-emerald-300">{{ ucfirst($member->status) }}</span>
                    </div>
                    <p class="mt-2 text-slate-400">{{ $member->motor_type ?? '-' }}</p>
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>
