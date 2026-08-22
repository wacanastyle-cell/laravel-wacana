<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('category')->nullable()->after('description');

            $table->boolean('featured')
                ->default(false)
                ->after('status');

            $table->string('event_name')
                ->nullable()
                ->after('event_date');

            $table->string('location')
                ->nullable()
                ->after('event_name');

            $table->string('city')
                ->nullable()
                ->after('location');

            $table->string('organizer')
                ->nullable()
                ->after('city');

            $table->text('event_description')
                ->nullable()
                ->after('organizer');

            $table->boolean('show_title')
                ->default(true)
                ->after('event_description');

            $table->boolean('show_description')
                ->default(true)
                ->after('show_title');

            $table->boolean('show_date')
                ->default(true)
                ->after('show_description');

            $table->boolean('show_location')
                ->default(true)
                ->after('show_date');

            $table->boolean('show_category')
                ->default(true)
                ->after('show_location');

            $table->boolean('show_video')
                ->default(true)
                ->after('show_category');

            $table->string('seo_title')
                ->nullable()
                ->after('show_video');

            $table->text('meta_description')
                ->nullable()
                ->after('seo_title');

            $table->string('seo_image')
                ->nullable()
                ->after('meta_description');

            $table->string('canonical_url')
                ->nullable()
                ->after('seo_image');

            $table->timestamp('published_at')
                ->nullable()
                ->after('canonical_url');

            $table->timestamp('scheduled_at')
                ->nullable()
                ->after('published_at');

            $table->softDeletes();
        });

        Schema::table('gallery_photos', function (Blueprint $table) {
            $table->string('title')
                ->nullable()
                ->after('image');

            $table->text('alt_text')
                ->nullable()
                ->after('caption');
        });

        Schema::create('gallery_videos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gallery_id')
                ->constrained('galleries')
                ->cascadeOnDelete();

            $table->string('youtube_url')
                ->nullable();

            $table->string('external_url')
                ->nullable();

            $table->string('thumbnail')
                ->nullable();

            $table->string('title')
                ->nullable();

            $table->text('description')
                ->nullable();

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->timestamps();

            $table->index([
                'gallery_id',
                'sort_order'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_videos');

        Schema::table('gallery_photos', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'alt_text',
            ]);
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropSoftDeletes();

            $table->dropColumn([
                'category',
                'featured',
                'event_name',
                'location',
                'city',
                'organizer',
                'event_description',
                'show_title',
                'show_description',
                'show_date',
                'show_location',
                'show_category',
                'show_video',
                'seo_title',
                'meta_description',
                'seo_image',
                'canonical_url',
                'published_at',
                'scheduled_at',
            ]);
        });
    }
};
