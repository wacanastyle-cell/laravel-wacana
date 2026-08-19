<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('navigation_menus')) {
            Schema::create('navigation_menus', function (Blueprint $table) {
                $table->id();
                $table->string('label');
                $table->string('slug')->unique();
                $table->string('href');
                $table->enum('type', ['internal', 'external', 'anchor'])->default('internal');
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->string('icon')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();

                $table->index(['is_active', 'sort_order']);
                $table->index(['parent_id']);
                $table->foreign('parent_id')->references('id')->on('navigation_menus')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_menus');
    }
};

