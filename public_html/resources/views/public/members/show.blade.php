@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $member->name }} | {{ $siteName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100">
    <div class="max-w-4xl mx-auto py-16 px-4">
        <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800">
            <div class="flex flex-col md:flex-row gap-6">
                @if($member->photo)
                    <img src="{{ Storage::disk('public')->url($member->photo) }}" alt="{{ $member->name }}" class="w-full md:w-64 h-64 object-cover rounded-xl">
                @endif
                <div class="flex-1">
                    <h1 class="text-3xl font-bold">{{ $member->name }}</h1>
                    <p class="text-red-400 mt-2">{{ $member->member_number }}</p>
                    <div class="mt-4 space-y-2 text-slate-300">
                        <p>Motor: {{ $member->motor_type ?? '-' }}</p>
                        <p>Kota: {{ $member->city ?? '-' }}</p>
                        <p>WhatsApp: {{ $member->whatsapp ?? '-' }}</p>
                        <p>Instagram: {{ $member->instagram ?? '-' }}</p>
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
</body>
</html>
