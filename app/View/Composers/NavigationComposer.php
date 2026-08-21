<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Page;

class NavigationComposer
{
    public function compose(View $view)
    {
        // Ambil halaman ABOUT yang sudah tersedia dari Admin Panel.
        // Menggunakan slug yang benar sesuai data Page saat ini.
        $aboutDynamicPages = Page::whereIn('slug', [            
'tentang',                'kebijakan',                'syarat-ketentuan',                'peraturan-tim',
        ])->get();

        // Construct main menu.
        // Desktop dan Mobile menggunakan sumber data menu yang sama.
        $mainMenu = [
            [
                'title' => 'Beranda',
                'url' => url('/'),
                'type' => 'link',
            ],
            [
                'title' => 'Galeri',
                'url' => route('public.galleries'),
                'type' => 'link',
            ],
            [
                'title' => 'EVENT',
                'url' => route('public.forms'),
                'type' => 'link',
            ],
            [
                'title' => 'Blog',
                'url' => route('public.blogs'),
                'type' => 'link',
            ],
            [
                'title' => 'ABOUT',
                'type' => 'dropdown',
                'children' => array_merge(
                    $aboutDynamicPages->map(function ($page) {
                        return [
                            'title' => $page->title,
                            'url' => route('public.page', $page->slug),
                            'type' => 'link',
                        ];
                    })->toArray(),
                    [
                        [
                            'title' => 'FAQ',
                            'url' => route('public.faqs'),
                            'type' => 'link',
                        ],
                    ]
                ),
            ],
        ];

        $view->with('mainMenu', $mainMenu);
    }
}
