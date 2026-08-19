<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_number')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('photo')->nullable();
            $table->string('motor_type')->nullable();
            $table->string('motor_year')->nullable();
            $table->string('city')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('instagram')->nullable();
            $table->text('bio')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('joined_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};