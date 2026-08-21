<?php

return [

    'class_namespace' => 'App\\Livewire',

    'view_path' => resource_path('views/livewire'),

    'layout' => 'components.layouts.app',

    'temporary_file_upload' => [

        /*
         * Gunakan disk public yang sudah tersedia.
         */
        'disk' => 'public',

        /*
         * Folder temporary upload Livewire.
         */
        'directory' => 'livewire-tmp',

        /*
         * Maksimal 500 MB.
         */
        'rules' => [
            'required',
            'file',
            'max:512000',
        ],

        /*
         * Preview temporary file.
         */
        'preview_mimes' => [
            'png',
            'gif',
            'bmp',
            'svg',
            'wav',
            'mp4',
            'mov',
            'avi',
            'wmv',
            'mp3',
            'm4a',
            'jpg',
            'jpeg',
            'webp',
        ],

        'max_upload_time' => 60,

        'middleware' => 'throttle:60,1',

        'preview' => [
            'rules' => [
                'required',
                'file',
                'max:512000',
            ],
        ],
    ],

    'inject_assets' => true,

    'navigate' => [
        'show_progress_bar' => true,
    ],

    'smart_wire_keys' => false,

    'pagination_theme' => 'tailwind',

];
