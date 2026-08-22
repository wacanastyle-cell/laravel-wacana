<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    [PublicPageController::class, 'home']
)->name('home');

Route::get(
    '/landing',
    [PublicPageController::class, 'home']
)->name('landing');

Route::post(
    '/member/join',
    [PublicPageController::class, 'storeMember']
)->name('public.member.join');


/*
|--------------------------------------------------------------------------
| Gallery
|--------------------------------------------------------------------------
*/

Route::get(
    '/galeri',
    [PublicPageController::class, 'galleries']
)->name('public.galleries');

Route::get(
    '/galeri/{slug}',
    [PublicPageController::class, 'galleryDetail']
)->name('public.gallery.detail');


/*
|--------------------------------------------------------------------------
| Blog
|--------------------------------------------------------------------------
*/

Route::get(
    '/blog',
    [PublicPageController::class, 'blogs']
)->name('public.blogs');

Route::get(
    '/blog/{slug}',
    [PublicPageController::class, 'blogDetail']
)->name('public.blog.show');


/*
|--------------------------------------------------------------------------
| FAQ & Pages
|--------------------------------------------------------------------------
*/

Route::get(
    '/faq',
    [PublicPageController::class, 'faqs']
)->name('public.faqs');

Route::get(
    '/page/{slug}',
    [PublicPageController::class, 'page']
)->name('public.page');


/*
|--------------------------------------------------------------------------
| Public Forms
|--------------------------------------------------------------------------
*/

Route::get(
    '/formulir',
    [FormController::class, 'index']
)->name('public.forms');

Route::get(
    '/form/{slug}',
    [FormController::class, 'show']
)->name('public.form.show');

Route::post(
    '/form/{slug}',
    [FormController::class, 'store']
)->name('public.form.store');


/*
|--------------------------------------------------------------------------
| Public Storage Fallback
|--------------------------------------------------------------------------
*/

Route::get('/storage/{path}', function ($path) {

    $file = public_path(
        'storage/' . $path
    );

    if (! file_exists($file)) {
        abort(404);
    }

    return response()->file($file);

})->where('path', '.*');


/*
|--------------------------------------------------------------------------
| Admin Form Submission Export / Print
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/admin/form-submissions-export/csv',
        [
            \App\Http\Controllers\FormSubmissionExportController::class,
            'csv'
        ]
    )->name(
        'admin.form-submissions.csv'
    );

    Route::get(
        '/admin/form-submissions-export/excel',
        [
            \App\Http\Controllers\FormSubmissionExportController::class,
            'excel'
        ]
    )->name(
        'admin.form-submissions.excel'
    );

    Route::get(
        '/admin/form-submissions-export/print',
        [
            \App\Http\Controllers\FormSubmissionExportController::class,
            'printAll'
        ]
    )->name(
        'admin.form-submissions.print'
    );

    Route::get(
        '/admin/form-submissions-export/{submission}/print',
        [
            \App\Http\Controllers\FormSubmissionExportController::class,
            'printOne'
        ]
    )->name(
        'admin.form-submissions.print-one'
    );

});


/*
|--------------------------------------------------------------------------
| XML Sitemap
|--------------------------------------------------------------------------
*/

Route::get(
    '/sitemap.xml',
    [\App\Http\Controllers\SitemapController::class, 'index']
)->name('sitemap');

