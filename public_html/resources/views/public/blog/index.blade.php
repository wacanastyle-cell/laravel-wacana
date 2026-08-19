@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog | {{ $siteName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100">
    <!-- Navigation -->
    <nav class="bg-slate-900 border-b border-slate-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-red-500">{{ $siteName }}</a>
            <div class="space-x-6">
                <a href="{{ route('home') }}" class="hover:text-red-500 transition">Beranda</a>
                <a href="{{ route('public.galleries') }}" class="hover:text-red-500 transition">Galeri</a>
                <a href="{{ route('public.blogs') }}" class="hover:text-red-500 transition">Blog</a>
                <a href="{{ route('public.faqs') }}" class="hover:text-red-500 transition">FAQ</a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto py-16 px-4">
        <h1 class="text-4xl font-bold mb-2">Blog {{ $siteName }}</h1>
        <p class="text-slate-400 mb-8">Artikel dan berita terbaru dari komunitas kami</p>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($blogs as $blog)
                <a href="{{ route('public.blog.show', $blog->slug) }}" class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-800 hover:border-red-500 transition group">
                    @if($blog->featured_image)
                        <img src="{{ Storage::disk('public')->url($blog->featured_image) }}" alt="{{ $blog->title }}" class="h-56 w-full object-cover group-hover:scale-105 transition">
                    @else
                        <div class="h-56 w-full bg-slate-800 flex items-center justify-center">
                            <span class="text-slate-600">No Image</span>
                        </div>
                    @endif
                    <div class="p-5">
                        <p class="text-sm text-red-400">{{ $blog->published_at->format('d M Y') }}</p>
                        <h3 class="text-xl font-semibold mt-2">{{ $blog->title }}</h3>
                        <p class="text-slate-300 mt-3 line-clamp-3">{{ $blog->excerpt ?? Str::limit($blog->content, 150) }}</p>
                        <div class="mt-4 flex items-center text-red-500 font-semibold group-hover:translate-x-1 transition">
                            Baca Selengkapnya →
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-slate-400 text-lg">Belum ada artikel yang dipublikasikan</p>
                </div>
            @endforelse
        </div>

        @if($blogs->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 mt-24 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. Semua hak cipta dilindungi.</p>
        </div>
    </footer>
</body>
</html>
