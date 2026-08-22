<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Form;
use App\Models\Gallery;
use App\Models\Page;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        /*
        |--------------------------------------------------------------------------
        | STATIC PUBLIC PAGES
        |--------------------------------------------------------------------------
        */

        $urls[] = [
            'loc' => route('home'),
            'lastmod' => now()->toDateString(),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        $urls[] = [
            'loc' => route('public.blogs'),
            'lastmod' => Blog::query()
                ->where('status', 'published')
                ->max('updated_at')?->toDateString(),
            'changefreq' => 'daily',
            'priority' => '0.9',
        ];

        $urls[] = [
            'loc' => route('public.galleries'),
            'lastmod' => Gallery::query()
                ->where('status', 'published')
                ->max('updated_at')?->toDateString(),
            'changefreq' => 'weekly',
            'priority' => '0.8',
        ];

        $urls[] = [
            'loc' => route('public.faqs'),
            'lastmod' => now()->toDateString(),
            'changefreq' => 'weekly',
            'priority' => '0.7',
        ];

        $urls[] = [
            'loc' => route('public.forms'),
            'lastmod' => Form::query()
                ->where('status', 'open')
                ->max('updated_at')?->toDateString(),
            'changefreq' => 'daily',
            'priority' => '0.8',
        ];


        /*
        |--------------------------------------------------------------------------
        | BLOG
        |--------------------------------------------------------------------------
        */

        $blogs = Blog::query()
            ->where('status', 'published')
            ->where(function ($query) {
                $query
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderByDesc('updated_at')
            ->get();

        foreach ($blogs as $blog) {
            $urls[] = [
                'loc' => route(
                    'public.blog.show',
                    ['slug' => $blog->slug]
                ),
                'lastmod' => $blog->updated_at?->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | GALLERY
        |--------------------------------------------------------------------------
        */

        $galleries = Gallery::query()
            ->where('status', 'published')
            ->where(function ($query) {
                $query
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderByDesc('updated_at')
            ->get();

        foreach ($galleries as $gallery) {
            $urls[] = [
                'loc' => route(
                    'public.gallery.detail',
                    ['slug' => $gallery->slug]
                ),
                'lastmod' => $gallery->updated_at?->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | CMS PAGES
        |--------------------------------------------------------------------------
        */

        $pages = Page::query()
            ->where('status', 'published')
            ->where('seo_index', true)
            ->where(function ($query) {
                $query
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderBy('menu_order')
            ->get();

        foreach ($pages as $page) {
            $urls[] = [
                'loc' => route(
                    'public.page',
                    ['slug' => $page->slug]
                ),
                'lastmod' => $page->updated_at?->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | ACTIVE FORMS
        |--------------------------------------------------------------------------
        */

        $forms = Form::query()
            ->where('status', 'open')
            ->where(function ($query) {
                $query
                    ->whereNull('registration_start')
                    ->orWhere('registration_start', '<=', now());
            })
            ->where(function ($query) {
                $query
                    ->whereNull('registration_end')
                    ->orWhere('registration_end', '>=', now());
            })
            ->orderByDesc('updated_at')
            ->get();

        foreach ($forms as $form) {
            $urls[] = [
                'loc' => route(
                    'public.form.show',
                    ['slug' => $form->slug]
                ),
                'lastmod' => $form->updated_at?->toDateString(),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ];
        }


        return response()
            ->view(
                'sitemap',
                compact('urls')
            )
            ->header(
                'Content-Type',
                'application/xml; charset=UTF-8'
            );
    }
}
