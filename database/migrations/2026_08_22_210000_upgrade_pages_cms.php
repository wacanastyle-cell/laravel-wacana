<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {

            $table->timestamp('published_at')
                ->nullable()
                ->after('status');

            $table->timestamp('scheduled_at')
                ->nullable()
                ->after('published_at');

            $table->string('template')
                ->default('default')
                ->after('scheduled_at');

            $table->unsignedBigInteger('parent_id')
                ->nullable()
                ->after('template');

            $table->unsignedInteger('menu_order')
                ->default(0)
                ->after('parent_id');

            $table->boolean('comments_enabled')
                ->default(false)
                ->after('menu_order');

            $table->string('seo_title')
                ->nullable()
                ->after('comments_enabled');

            $table->text('meta_description')
                ->nullable()
                ->after('seo_title');

            $table->text('meta_keywords')
                ->nullable()
                ->after('meta_description');

            $table->string('canonical_url')
                ->nullable()
                ->after('meta_keywords');

            $table->boolean('seo_index')
                ->default(true)
                ->after('canonical_url');

            $table->string('og_image')
                ->nullable()
                ->after('seo_index');

            $table->string('custom_css_class')
                ->nullable()
                ->after('og_image');

            $table->longText('custom_fields')
                ->nullable()
                ->after('custom_css_class');

            $table->boolean('show_featured_image')
                ->default(true)
                ->after('show_excerpt');

            $table->boolean('show_breadcrumb')
                ->default(true)
                ->after('show_featured_image');

            $table->boolean('show_header')
                ->default(true)
                ->after('show_breadcrumb');

            $table->boolean('show_footer')
                ->default(true)
                ->after('show_header');

            $table->boolean('show_sidebar')
                ->default(false)
                ->after('show_footer');

            $table->boolean('show_published_date')
                ->default(false)
                ->after('show_sidebar');

            $table->boolean('show_author')
                ->default(false)
                ->after('show_published_date');

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {

            $table->dropSoftDeletes();

            $table->dropColumn([
                'published_at',
                'scheduled_at',
                'template',
                'parent_id',
                'menu_order',
                'comments_enabled',
                'seo_title',
                'meta_description',
                'meta_keywords',
                'canonical_url',
                'seo_index',
                'og_image',
                'custom_css_class',
                'custom_fields',
                'show_featured_image',
                'show_breadcrumb',
                'show_header',
                'show_footer',
                'show_sidebar',
                'show_published_date',
                'show_author',
            ]);
        });
    }
};
