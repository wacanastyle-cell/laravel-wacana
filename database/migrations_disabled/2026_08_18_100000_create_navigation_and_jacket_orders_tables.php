<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create navigation_menus table
        Schema::create('navigation_menus', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('slug')->unique();
            $table->string('type')->default('link'); // link, page, external, dropdown
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('navigation_menus')->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('target')->default('_self'); // _self, _blank
            $table->timestamps();

            $table->index(['parent_id', 'sort_order']);
            $table->index(['is_active']);
        });

        // Create jacket_orders table
        Schema::create('jacket_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->string('customer_address')->nullable();
            $table->string('jacket_type');
            $table->string('jacket_model');
            $table->string('jacket_color');
            $table->string('jacket_size');
            $table->unsignedInteger('jacket_quantity')->default(1);
            $table->text('jacket_design_notes')->nullable();
            $table->string('jacket_design_file')->nullable();
            $table->decimal('unit_price', 12, 2)->default(180000);
            $table->decimal('extra_price', 12, 2)->default(0); // XL surcharge, etc
            $table->decimal('total_price', 12, 2);
            $table->enum('status', ['new', 'processing', 'confirmed', 'production', 'completed', 'cancelled'])->default('new');
            $table->text('notes')->nullable();
            $table->timestamp('ordered_at')->nullable();
            $table->timestamps();

            $table->index(['status']);
            $table->index(['customer_phone']);
            $table->index(['ordered_at']);
        });

        // Extend settings table with more categories
        Schema::table('settings', function (Blueprint $table) {
            // Already exists, but adding index for better performance
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jacket_orders');
        Schema::dropIfExists('navigation_menus');
    }
};
