<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('category')->nullable()->after('excerpt');
            $table->text('tags')->nullable()->after('category');

            $table->boolean('featured')->default(false)->after('tags');

            $table->boolean('show_thumbnail')->default(true)->after('show_excerpt');
            $table->boolean('show_author')->default(true)->after('show_thumbnail');
            $table->boolean('show_date')->default(true)->after('show_author');
            $table->boolean('show_category')->default(true)->after('show_date');
            $table->boolean('show_tags')->default(true)->after('show_category');
            $table->boolean('show_reading_time')->default(true)->after('show_tags');

            $table->string('seo_title')->nullable()->after('show_reading_time');
            $table->text('meta_description')->nullable()->after('seo_title');
            $table->string('focus_keyword')->nullable()->after('meta_description');
            $table->string('canonical_url')->nullable()->after('focus_keyword');

            $table->string('og_title')->nullable()->after('canonical_url');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');

            $table->unsignedBigInteger('views')->default(0)->after('og_image');
            $table->unsignedInteger('reading_time')->default(0)->after('views');
            $table->unsignedInteger('word_count')->default(0)->after('reading_time');
            $table->unsignedInteger('character_count')->default(0)->after('word_count');

            $table->boolean('autosave')->default(true)->after('character_count');

            $table->timestamp('scheduled_at')->nullable()->after('published_at');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'tags',
                'featured',
                'show_thumbnail',
                'show_author',
                'show_date',
                'show_category',
                'show_tags',
                'show_reading_time',
                'seo_title',
                'meta_description',
                'focus_keyword',
                'canonical_url',
                'og_title',
                'og_description',
                'og_image',
                'views',
                'reading_time',
                'word_count',
                'character_count',
                'autosave',
                'scheduled_at',
            ]);
        });
    }
};
