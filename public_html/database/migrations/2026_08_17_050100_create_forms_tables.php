<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'open', 'closed', 'archived'])->default('draft');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->text('confirmation_message')->nullable();
            $table->boolean('email_notification_enabled')->default(false);
            $table->boolean('admin_notification_enabled')->default(false);
            $table->timestamps();

            $table->index(['status']);
        });

        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('name');
            $table->enum('type', ['text', 'textarea', 'email', 'phone', 'number', 'date', 'select', 'radio', 'checkbox', 'file', 'image'])->default('text');
            $table->string('placeholder')->nullable();
            $table->text('description')->nullable();
            $table->json('options')->nullable();
            $table->json('validation_rules')->nullable();
            $table->boolean('is_required')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['form_id', 'sort_order']);
        });

        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained()->cascadeOnDelete();
            $table->string('reference_number')->unique();
            $table->string('submitter_name')->nullable();
            $table->string('submitter_email')->nullable();
            $table->string('submitter_phone')->nullable();
            $table->json('data');
            $table->enum('status', ['new', 'processing', 'accepted', 'rejected', 'completed'])->default('new');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->index(['form_id', 'status']);
            $table->index(['status']);
            $table->index(['submitted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
        Schema::dropIfExists('form_fields');
        Schema::dropIfExists('forms');
    }
};