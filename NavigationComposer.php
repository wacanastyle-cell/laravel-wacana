<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Page; // Asumsi model Page Anda ada di sini

class NavigationComposer
{
    public function compose(View $view)
    {
        // Ambil halaman-halaman yang relevan dari database
        $aboutDynamicPages = Page::whereIn('slug', [
            'peraturan-tim',
            'tentang-kami',
            'kebijakan-privasi',
            'syarat-ketentuan',
        ])->get();
        
        // Construct the main menu, ensuring consistency between desktop and mobile
        $mainMenu = [
            ['title' => 'Beranda', 'url' => url('/'), 'type' => 'link'],
            ['title' => 'Galeri', 'url' => route('public.galleries'), 'type' => 'link'],
            ['title' => 'Formulir', 'url' => route('public.forms'), 'type' => 'link'],
            ['title' => 'Blog', 'url' => route('public.blogs'), 'type' => 'link'],
            [
                'title' => 'ABOUT',
                'type' => 'dropdown',
                'children' => array_merge(
                    $aboutDynamicPages->map(function($page) {
                        return ['title' => $page->title, 'url' => route('public.page', $page->slug), 'type' => 'link'];
                    })->toArray(),
                    [['title' => 'FAQ', 'url' => route('public.faqs'), 'type' => 'link']]
                )
            ],
        ];
        $view->with('mainMenu', $mainMenu);
    }
}