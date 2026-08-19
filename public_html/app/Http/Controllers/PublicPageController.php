<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Member;
use App\Models\Page;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    public function home()
    {
        $latestBlogs = Blog::query()
            ->where('status', 'published')
            ->recent()
            ->limit(3)
            ->get();

        return view('home', compact('latestBlogs'));
    }

    public function galleries()
    {
        $galleries = Gallery::query()
            ->where('status', 'published')
            ->orderByDesc('event_date')
            ->get();

        return view('public.gallery.index', compact('galleries'));
    }

    public function galleryDetail(string $slug)
    {
        $gallery = Gallery::query()->where('slug', $slug)->firstOrFail();

        return view('public.gallery.show', compact('gallery'));
    }

    public function blogs()
    {
        $blogs = Blog::query()
            ->where('status', 'published')
            ->recent()
            ->paginate(9);

        return view('public.blog.index', compact('blogs'));
    }

    public function blogDetail(string $slug)
    {
        $blog = Blog::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedBlogs = Blog::query()
            ->where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->recent()
            ->limit(3)
            ->get();

        return view('public.blog.show', compact('blog', 'relatedBlogs'));
    }

    public function faqs()
    {
        $faqs = Faq::query()->where('is_active', true)->orderBy('sort_order')->get();

        return view('public.faq.index', compact('faqs'));
    }

    public function page(string $slug)
    {
        $page = Page::query()->where('slug', $slug)->where('status', 'published')->firstOrFail();

        return view('public.pages.show', compact('page'));
    }
}
