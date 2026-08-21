<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('forms') && ! Schema::hasColumn('forms', 'thumbnail')) {
            Schema::table('forms', function (Blueprint $table) {
                $table->string('thumbnail')->nullable()->after('description');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('forms') && Schema::hasColumn('forms', 'thumbnail')) {
            Schema::table('forms', function (Blueprint $table) {
                $table->dropColumn('thumbnail');
            });
        }
    }
};
