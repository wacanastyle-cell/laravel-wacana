@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
    {{-- Header --}}
    <div class="ws-page-header">
        <div class="ws-page-header-inner">
            <h1 class="ws-page-title">Frequently Asked Questions (FAQ)</h1>
            <p class="ws-page-subtitle">Temukan jawaban untuk pertanyaan yang sering diajukan tentang komunitas kami.</p>
        </div>
    </div>

    <main class="ws-page-main">
        <div class="max-w-4xl mx-auto" x-data="{ open: null }">
            @forelse($faqs as $faq)
                <div class="ws-faq-item">
                    <button @click="open = open === {{ $faq->id }} ? null : {{ $faq->id }}" class="ws-faq-question">
                        <span>{{ $faq->question }}</span>
                        <i class="fa-solid fa-chevron-down transition-transform"
                           :class="open === {{ $faq->id }} && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === {{ $faq->id }}" x-collapse class="ws-faq-answer">
                        <div class="prose max-w-none">
                            {!! $faq->answer !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-400">Saat ini belum ada FAQ yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </main>
@endsection