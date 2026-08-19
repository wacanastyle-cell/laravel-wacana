<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Member;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicPageController extends Controller
{
    public function home()
    {
        $latestBlogs = Blog::query()
            ->where('status', 'published')
            ->recent()
            ->limit(3)
            ->get();

        $faqs = Faq::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        $publishedPages = Page::query()
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();

        $featuredGalleries = Gallery::query()
            ->where('status', 'published')
            ->orderBy('event_date', 'desc')
            ->limit(6)
            ->get();

        $memberCount = Member::query()
            ->where('status', 'active')
            ->count();

        return view('home', compact(
            'latestBlogs',
            'faqs',
            'publishedPages',
            'featuredGalleries',
            'memberCount'
        ));
    }

    public function storeMember(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:255',
            'motor_type' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.max' => 'Nomor WhatsApp maksimal 255 karakter.',
            'motor_type.required' => 'Jenis / tipe motor wajib diisi.',
            'motor_type.max' => 'Jenis / tipe motor maksimal 255 karakter.',
            'city.required' => 'Domisili wajib diisi.',
            'city.max' => 'Domisili maksimal 255 karakter.',
        ]);

        $latest = Member::query()->latest('id')->value('member_number');
        $sequence = $latest ? (int) substr($latest, -4) + 1 : 1;
        $memberNumber = 'WS-' . now()->format('Ymd') . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        $member = Member::create([
            'member_number' => $memberNumber,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::lower(Str::random(6)),
            'whatsapp' => $validated['whatsapp'],
            'motor_type' => $validated['motor_type'],
            'city' => $validated['city'],
            'status' => 'inactive',
            'joined_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil diterima.',
            'member' => $member,
        ]);
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
