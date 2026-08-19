@extends('layouts.app')

@section('title', 'Galeri')

@section('content')
    {{-- Header --}}
    <div class="ws-page-header">
        <div class="ws-page-header-inner">
            <h1 class="ws-page-title">Galeri Kegiatan</h1>
            <p class="ws-page-subtitle">Momen dan kenangan dari setiap perjalanan dan acara yang kami adakan.</p>
        </div>
    </div>

    <main class="ws-page-main">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($galleries as $gallery)
                <a href="{{ route('public.gallery.detail', $gallery->slug) }}" class="ws-gallery-item group">
                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" loading="lazy">
                    <div class="ws-gallery-item-overlay">
                        <h4 class="ws-gallery-item-title">{{ $gallery->title }}</h4>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-400">Belum ada foto di galeri.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-12">
            {{ $galleries->links() }}
        </div>
    </main>
@endsection