```blade
@extends('layouts.app')

@section('title', $page->title)

@section('content')
    {{-- Header --}}
    <div class="ws-page-header relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-white to-gray-100"></div>

        <div class="relative ws-page-header-inner max-w-7xl mx-auto px-6 lg:px-8 py-14 md:py-20">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 mb-5 rounded-full bg-white border border-gray-200 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-black"></span>
                    <span class="text-xs md:text-sm font-medium tracking-widest uppercase text-gray-600">
                        {{ $page->title }}
                    </span>
                </div>

                <h1 class="ws-page-title text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight text-gray-900 leading-tight">
                    {{ $page->title }}
                </h1>

                <div class="w-16 h-1 bg-gray-900 rounded-full mx-auto mt-7"></div>
            </div>
        </div>
    </div>

    <main class="ws-page-main bg-gray-50 min-h-[60vh]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
            <div class="bg-white rounded-2xl md:rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-8 sm:px-10 sm:py-10 md:px-14 md:py-14 lg:px-16">
                    <div class="ws-page-content prose prose-gray prose-lg max-w-4xl mx-auto
                        prose-headings:text-gray-900
                        prose-headings:font-bold
                        prose-h1:text-3xl
                        prose-h2:text-2xl
                        prose-h3:text-xl
                        prose-p:text-gray-600
                        prose-p:leading-8
                        prose-a:text-gray-900
                        prose-a:font-semibold
                        prose-a:underline
                        prose-a:underline-offset-4
                        prose-strong:text-gray-900
                        prose-li:text-gray-600
                        prose-li:leading-7
                        prose-blockquote:border-gray-900
                        prose-blockquote:bg-gray-50
                        prose-blockquote:rounded-xl
                        prose-blockquote:px-6
                        prose-blockquote:py-3
                        prose-img:rounded-2xl
                        prose-img:shadow-md">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
```
