@php
    use Illuminate\Support\Facades\Storage;
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }} | {{ $siteName }}</title>
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
        .prose{max-width:none}
        .prose-headings{color:#fff}
        .prose-p{color:#a1a1aa;line-height:1.8}
        .prose-a{color:#ef4444}
    </style>
</head>
<body>

@include('partials.header-nav')

<div class="container">
    <div class="mb-8">
        <a href="{{ route('public.blogs') }}" class="text-red-500 hover:text-red-400">← Kembali ke Blog</a>
    </div>

    @if($blog->featured_image)
        <img src="{{ url('/storage/' . ltrim($blog->featured_image, '/')) }}" alt="{{ $blog->title }}" class="w-full rounded-2xl mb-8">
    @endif

    <h1 class="text-5xl font-bold mb-4">{{ $blog->title }}</h1>
    <div class="flex items-center space-x-4 text-slate-400 mb-8 pb-8 border-b border-slate-800">
        <span>{{ $blog->published_at->format('d M Y') }}</span>
        <span>•</span>
        <span>Oleh {{ $blog->user->name }}</span>
    </div>

    <div class="prose prose-invert max-w-none
        prose-headings:text-white prose-headings:font-bold
        prose-h1:text-3xl prose-h1:mt-8 prose-h1:mb-4
        prose-h2:text-2xl prose-h2:mt-6 prose-h2:mb-3
        prose-p:text-slate-300 prose-p:leading-relaxed prose-p:mb-4
        prose-a:text-red-500 prose-a:hover:text-red-400
        prose-strong:text-white
        prose-code:bg-slate-800 prose-code:text-red-400 prose-code:px-2 prose-code:py-1 prose-code:rounded
        prose-pre:bg-slate-800 prose-pre:border prose-pre:border-slate-700
        prose-blockquote:border-red-500 prose-blockquote:text-slate-300
        prose-li:text-slate-300
        prose-img:rounded-xl prose-img:my-6">
        {!! $blog->content !!}
    </div>

    <div class="mt-12 pt-8 border-t border-slate-800">
        <div class="bg-slate-900 p-6 rounded-xl border border-slate-800">
            <h3 class="text-xl font-semibold mb-2">Tentang {{ $blog->user->name }}</h3>
            <p class="text-slate-300">Anggota komunitas {{ $siteName }} yang aktif berbagi pengalaman dan pengetahuan.</p>
        </div>
    </div>

    <!-- Related Posts -->
    @if($relatedBlogs->count() > 0)
        <div class="mt-16">
            <h2 class="text-3xl font-bold mb-8">Artikel Terkait</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($relatedBlogs as $relatedBlog)
                    <a href="{{ route('public.blog.show', $relatedBlog->slug) }}" class="bg-slate-900 rounded-xl overflow-hidden border border-slate-800 hover:border-red-500 transition group">
                        @if($relatedBlog->featured_image)
                            <img src="{{ url('/storage/' . ltrim($relatedBlog->featured_image, '/')) }}" alt="{{ $relatedBlog->title }}" class="h-40 w-full object-cover group-hover:scale-105 transition">
                        @endif
                        <div class="p-4">
                            <h4 class="font-semibold">{{ $relatedBlog->title }}</h4>
                            <p class="text-sm text-slate-400 mt-2">{{ $relatedBlog->published_at->format('d M Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

@include('partials.footer')

</body>
</html>
