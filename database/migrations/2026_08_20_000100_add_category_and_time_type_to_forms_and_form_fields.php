<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom kategori di tabel forms
        if (Schema::hasTable('forms') && !Schema::hasColumn('forms', 'category')) {
            Schema::table('forms', function (Blueprint $table) {
                $table->string('category', 50)->nullable()->after('slug');
            });
        }

        // 2. Perluas tipe field di form_fields
        // Mengubah enum menjadi string agar fleksibel mendukung tipe baru (time, tel, dll)
        if (Schema::hasTable('form_fields')) {
            Schema::table('form_fields', function (Blueprint $table) {
                $table->string('type', 50)->default('text')->change();
            });
        }
    }

    public function down(): void
    {
        // Tetap biarkan string untuk keamanan data
    }
};
