<?php

namespace App\Http\View\Composers;

use App\Models\Page;
use Illuminate\View\View;

class NavigationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Menu navigation structure dengan submenu
        $navItems = [
            [
                'label' => 'HOME',
                'type' => 'link',
                'route' => 'home',
            ],
            [
                'label' => 'ABOUT',
                'type' => 'menu',
                'items' => [
                    [
                        'label' => 'TENTANG',
                        'type' => 'link',
                        'route' => 'public.page',
                        'slug' => 'tentang',
                    ],
                    [
                        'label' => 'KEBIJAKAN',
                        'type' => 'link',
                        'url' => 'https://wacanastyle.my.id/page/kebijakan',
                    ],
                    [
                        'label' => 'PERATURAN TIM',
                        'type' => 'link',
                        'url' => 'https://wacanastyle.my.id/page/peraturan-tim',
                    ],
                    [
                        'label' => 'SYARAT & KETENTUAN',
                        'type' => 'link',
                        'url' => 'https://wacanastyle.my.id/page/syarat-ketentuan',
                    ],
                    [
                        'label' => 'FAQ',
                        'type' => 'link',
                        'route' => 'public.faqs',
                    ],
                ],
            ],
            [
                'label' => 'GALERI',
                'type' => 'link',
                'route' => 'public.galleries',
            ],
            [
                'label' => 'BLOG',
                'type' => 'link',
                'route' => 'public.blogs',
            ],
            [
                'label' => 'EVENT',
                'type' => 'link',
                'route' => 'public.forms',
            ],
        ];

        $view->with('wsNavLinks', $navItems);
    }
}