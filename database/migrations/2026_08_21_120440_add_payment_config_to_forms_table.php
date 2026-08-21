<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->boolean('payment_enabled')->default(false)->after('thumbnail');
            $table->unsignedBigInteger('payment_amount')->nullable()->after('payment_enabled');
            $table->json('payment_methods')->nullable()->after('payment_amount');
        });
    }

    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn([
                'payment_enabled',
                'payment_amount',
                'payment_methods',
            ]);
        });
    }
};
