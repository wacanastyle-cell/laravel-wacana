<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPageController::class, 'home'])->name('home');
Route::get('/landing', [PublicPageController::class, 'home'])->name('landing');

Route::get('/galeri', [PublicPageController::class, 'galleries'])->name('public.galleries');
Route::get('/galeri/{slug}', [PublicPageController::class, 'galleryDetail'])->name('public.gallery.detail');

Route::get('/blog', [PublicPageController::class, 'blogs'])->name('public.blogs');
Route::get('/blog/{slug}', [PublicPageController::class, 'blogDetail'])->name('public.blog.show');

Route::get('/faq', [PublicPageController::class, 'faqs'])->name('public.faqs');
Route::get('/page/{slug}', [PublicPageController::class, 'page'])->name('public.page');
Route::get('/formulir', [FormController::class, 'index'])->name('public.forms');
Route::get('/form/{slug}', [FormController::class, 'show'])->name('public.form.show');
Route::post('/form/{slug}', [FormController::class, 'store'])->name('public.form.store');

Route::get('/storage/{path}', function ($path) {
    $file = public_path('storage/' . $path);

    if (! file_exists($file)) {
        abort(404);
    }

    return response()->file($file);
})->where('path', '.*');