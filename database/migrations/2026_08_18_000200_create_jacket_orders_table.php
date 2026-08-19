<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('jacket_orders')) {
            Schema::create('jacket_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->string('customer_address')->nullable();
            $table->string('jacket_type'); // e.g., "Kulit", "Bahan", "Hoodie"
            $table->string('jacket_model')->nullable();
            $table->json('colors')->nullable(); // Array of selected colors
            $table->json('sizes')->nullable(); // Array of sizes with quantities
            $table->integer('total_quantity')->default(1);
            $table->string('design_reference')->nullable(); // Path to uploaded design
            $table->text('notes')->nullable();
            $table->enum('status', ['new', 'processing', 'confirmed', 'completed', 'cancelled'])->default('new');
            $table->decimal('estimated_total', 12, 2)->nullable();
            $table->timestamp('ordered_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['order_number']);
            $table->index(['status']);
            $table->index(['ordered_at']);
            $table->index(['customer_phone']);
        });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('jacket_orders');
    }
};
