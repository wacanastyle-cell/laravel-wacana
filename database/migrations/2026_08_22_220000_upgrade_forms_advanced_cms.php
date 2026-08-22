<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forms', function (Blueprint $table) {

            /*
             * INFORMASI EVENT
             */
            $table->string('banner')->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->string('location')->nullable();
            $table->text('google_maps_url')->nullable();

            $table->timestamp('registration_start')->nullable();
            $table->timestamp('registration_end')->nullable();

            $table->unsignedInteger('quota')->nullable();

            /*
             * PEMBAYARAN
             */
            $table->decimal('promo_price', 15, 2)->nullable();
            $table->timestamp('payment_deadline')->nullable();

            $table->text('payment_instructions')->nullable();

            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_name')->nullable();

            $table->string('ewallet_name')->nullable();
            $table->string('ewallet_number')->nullable();

            $table->string('qris_image')->nullable();

            $table->boolean('payment_proof_required')
                ->default(false);

            /*
             * VARIASI HARGA
             */
            $table->json('price_variations')->nullable();

            /*
             * TAMPILAN
             */
            $table->boolean('show_title')->default(true);
            $table->boolean('show_description')->default(true);
            $table->boolean('show_banner')->default(true);
            $table->boolean('show_date')->default(true);
            $table->boolean('show_time')->default(true);
            $table->boolean('show_location')->default(true);
            $table->boolean('show_price')->default(true);
            $table->boolean('show_quota')->default(true);
            $table->boolean('show_remaining_quota')->default(true);
            $table->boolean('show_registration_count')->default(false);

            $table->string('submit_button_text')
                ->default('Kirim Formulir');

            /*
             * SUCCESS MESSAGE
             */
            $table->string('success_title')
                ->nullable();

            $table->text('success_message')
                ->nullable();

            $table->text('next_instructions')
                ->nullable();

            $table->boolean('show_payment_after_submit')
                ->default(false);

            $table->text('redirect_url')
                ->nullable();

            $table->boolean('open_whatsapp_after_submit')
                ->default(false);

            $table->string('whatsapp_number')
                ->nullable();

            $table->text('whatsapp_message')
                ->nullable();

            /*
             * PUBLIKASI
             */
            $table->timestamp('published_at')
                ->nullable();
        });


        Schema::table('form_fields', function (Blueprint $table) {

            /*
             * FIELD BUILDER
             */
            $table->text('default_value')
                ->nullable();

            $table->unsignedInteger('min_length')
                ->nullable();

            $table->unsignedInteger('max_length')
                ->nullable();

            $table->decimal('min_value', 15, 2)
                ->nullable();

            $table->decimal('max_value', 15, 2)
                ->nullable();

            $table->string('validation_format')
                ->nullable();

            $table->string('width')
                ->default('full');

            /*
             * CONDITIONAL FIELD
             */
            $table->boolean('conditional_enabled')
                ->default(false);

            $table->string('conditional_field')
                ->nullable();

            $table->string('conditional_operator')
                ->nullable();

            $table->text('conditional_value')
                ->nullable();

            /*
             * FIELD KHUSUS
             */
            $table->boolean('is_price_field')
                ->default(false);
        });


        Schema::table('form_submissions', function (Blueprint $table) {

            /*
             * STATUS PENDAFTARAN
             */
            $table->string('registration_status')
                ->default('pending');

            /*
             * STATUS PEMBAYARAN
             */
            $table->string('payment_status')
                ->default('unpaid');

            $table->decimal('payment_amount', 15, 2)
                ->nullable();

            $table->string('payment_method')
                ->nullable();

            $table->string('payment_proof')
                ->nullable();

            $table->timestamp('payment_verified_at')
                ->nullable();

            $table->text('payment_notes')
                ->nullable();

            /*
             * ADMIN
             */
            $table->text('admin_notes')
                ->nullable();
        });


        /*
         * INDEX TAMBAHAN
         */
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->index('registration_status');
            $table->index('payment_status');
        });
    }


    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {

            $table->dropIndex(['registration_status']);
            $table->dropIndex(['payment_status']);

            $table->dropColumn([
                'registration_status',
                'payment_status',
                'payment_amount',
                'payment_method',
                'payment_proof',
                'payment_verified_at',
                'payment_notes',
                'admin_notes',
            ]);
        });


        Schema::table('form_fields', function (Blueprint $table) {

            $table->dropColumn([
                'default_value',
                'min_length',
                'max_length',
                'min_value',
                'max_value',
                'validation_format',
                'width',
                'conditional_enabled',
                'conditional_field',
                'conditional_operator',
                'conditional_value',
                'is_price_field',
            ]);
        });


        Schema::table('forms', function (Blueprint $table) {

            $table->dropColumn([
                'banner',
                'event_date',
                'event_time',
                'location',
                'google_maps_url',
                'registration_start',
                'registration_end',
                'quota',
                'promo_price',
                'payment_deadline',
                'payment_instructions',
                'bank_name',
                'bank_account_number',
                'bank_account_name',
                'ewallet_name',
                'ewallet_number',
                'qris_image',
                'payment_proof_required',
                'price_variations',
                'show_title',
                'show_description',
                'show_banner',
                'show_date',
                'show_time',
                'show_location',
                'show_price',
                'show_quota',
                'show_remaining_quota',
                'show_registration_count',
                'submit_button_text',
                'success_title',
                'success_message',
                'next_instructions',
                'show_payment_after_submit',
                'redirect_url',
                'open_whatsapp_after_submit',
                'whatsapp_number',
                'whatsapp_message',
                'published_at',
            ]);
        });
    }
};
