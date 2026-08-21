<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * - blogs / pages  : opsi tampil-sembunyi judul (show_title) dan
     *                    ringkasan/deskripsi (show_excerpt)
     * - form_fields    : duk "group" (section card) dan lebar penuh
     */
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->boolean('show_title')->default(true)->after('published_at');
            $table->boolean('show_excerpt')->default(true)->after('show_title');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('show_title')->default(true)->after('status');
            $table->boolean('show_excerpt')->default(true)->after('show_title');
        });

        Schema::table('form_fields', function (Blueprint $table) {
            $table->string('group')->nullable()->after('description');
            $table->boolean('is_full_width')->default(false)->after('group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['show_title', 'show_excerpt']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['show_title', 'show_excerpt']);
        });

        Schema::table('form_fields', function (Blueprint $table) {
            $table->dropColumn(['group', 'is_full_width']);
        });
    }
};