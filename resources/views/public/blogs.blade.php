@extends('layouts.app')

@section('title', 'Blog')

@section('content')
    {{-- Header --}}
    <div class="ws-page-header">
        <div class="ws-page-header-inner">
            <h1 class="ws-page-title">Blog & Berita</h1>
            <p class="ws-page-subtitle">Ikuti cerita, tips, dan informasi terbaru dari komunitas Wacana Style.</p>
        </div>
    </div>

    <main class="ws-page-main">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($blogs as $blog)
                <a href="{{ route('public.blog.show', $blog->slug) }}" class="ws-blog-card group">
                    <div class="ws-blog-card-img">
                        <img src="{{ $blog->image_url ?? 'https://via.placeholder.com/400x250/1a1b1f/8b0000?text=Wacana+Style' }}"
                            alt="{{ $blog->title }}" loading="lazy">
                    </div>
                    <div class="ws-blog-card-content">
                        <span class="ws-blog-card-date">{{ $blog->published_at->translatedFormat('d F Y') }}</span>
                        <h3 class="ws-blog-card-title">{{ $blog->title }}</h3>
                        <p class="ws-blog-card-excerpt">{{ $blog->excerpt }}</p>
                        <span class="ws-blog-card-readmore">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-400">Belum ada artikel blog yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $blogs->links() }}
        </div>
    </main>
@endsection