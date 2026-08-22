<?php

namespace App\Http\Controllers;

use App\Mail\AdminFormSubmissionNotification;
use App\Mail\FormSubmissionConfirmation;
use App\Models\Form;
use App\Models\FormField;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::query()
            ->where('status', 'open')
            ->where(function ($query) {
                $query
                    ->whereNull('registration_start')
                    ->orWhere('registration_start', '<=', now());
            })
            ->where(function ($query) {
                $query
                    ->whereNull('registration_end')
                    ->orWhere('registration_end', '>=', now());
            })
            ->latest()
            ->get();

        return view('public.forms.index', compact('forms'));
    }

    public function show(string $slug)
    {
        $form = Form::query()
            ->with([
                'fields' => fn ($query) => $query->orderBy('sort_order'),
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        abort_unless($form->status === 'open', 404);

        $this->ensureRegistrationAvailable($form);

        $registrationCount = $form->submissions()
            ->whereNotIn('registration_status', ['cancelled', 'rejected'])
            ->count();

        $remainingQuota = $form->quota
            ? max(0, ((int) $form->quota) - $registrationCount)
            : null;

        return view(
            'public.forms.show',
            compact(
                'form',
                'registrationCount',
                'remainingQuota'
            )
        );
    }

    public function store(Request $request, string $slug)
    {
        $form = Form::query()
            ->with([
                'fields' => fn ($query) => $query->orderBy('sort_order'),
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        abort_unless($form->status === 'open', 404);

        $this->ensureRegistrationAvailable($form);

        /*
        |--------------------------------------------------------------------------
        | QUOTA CHECK
        |--------------------------------------------------------------------------
        */

        if ($form->quota) {
            $registrationCount = $form->submissions()
                ->whereNotIn('registration_status', ['cancelled', 'rejected'])
                ->count();

            if ($registrationCount >= (int) $form->quota) {
                throw ValidationException::withMessages([
                    'form' => 'Maaf, kuota pendaftaran sudah penuh.',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DYNAMIC VALIDATION
        |--------------------------------------------------------------------------
        */

        $rules = [];

        foreach ($form->fields as $field) {
            if (in_array($field->type, ['heading', 'info'], true)) {
                continue;
            }

            $fieldName = $field->name;

            if (! $fieldName) {
                continue;
            }

            $fieldRules = [];

            $conditionSatisfied = $this->conditionSatisfied(
                $request,
                $field
            );

            if ($field->is_required && $conditionSatisfied) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            switch ($field->type) {
                case 'email':
                    $fieldRules[] = 'email';
                    $fieldRules[] = 'max:255';
                    break;

                case 'tel':
                case 'phone':
                    $fieldRules[] = 'string';
                    $fieldRules[] = 'max:30';
                    $fieldRules[] = 'regex:/^[0-9+\-\s()]+$/';
                    break;

                case 'number':
                    $fieldRules[] = 'numeric';

                    if ($field->min_value !== null) {
                        $fieldRules[] = 'min:' . $field->min_value;
                    }

                    if ($field->max_value !== null) {
                        $fieldRules[] = 'max:' . $field->max_value;
                    }

                    break;

                case 'date':
                    $fieldRules[] = 'date';
                    break;

                case 'time':
                    $fieldRules[] = 'date_format:H:i';
                    break;

                case 'url':
                    $fieldRules[] = 'url';
                    $fieldRules[] = 'max:2048';
                    break;

                case 'file':
                    $fieldRules[] = 'file';
                    $fieldRules[] = 'max:10240';
                    $fieldRules[] = 'mimes:jpg,jpeg,png,webp,pdf,doc,docx';
                    break;

                case 'image':
                    $fieldRules[] = 'image';
                    $fieldRules[] = 'max:10240';
                    $fieldRules[] = 'mimes:jpg,jpeg,png,webp';
                    break;

                case 'checkbox':
                    if (! $field->isSingleCheckbox()) {
                        $fieldRules[] = 'array';
                    }
                    break;

                case 'select':
                case 'radio':
                    $options = $field->optionsList();

                    if (! empty($options)) {
                        $fieldRules[] = Rule::in($options);
                    }

                    break;

                default:
                    $fieldRules[] = 'string';

                    if ($field->min_length !== null) {
                        $fieldRules[] = 'min:' . $field->min_length;
                    }

                    if ($field->max_length !== null) {
                        $fieldRules[] = 'max:' . $field->max_length;
                    } else {
                        $fieldRules[] = 'max:5000';
                    }

                    break;
            }

            $rules[$fieldName] = $fieldRules;
        }

        $validated = $request->validate($rules);

        /*
        |--------------------------------------------------------------------------
        | BUILD SUBMISSION DATA
        |--------------------------------------------------------------------------
        */

        $data = [];

        foreach ($form->fields as $field) {
            if (in_array($field->type, ['heading', 'info'], true)) {
                continue;
            }

            $fieldName = $field->name;

            if (! $fieldName) {
                continue;
            }

            if (! $this->conditionSatisfied($request, $field)) {
                continue;
            }

            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);

                $extension = strtolower(
                    $file->getClientOriginalExtension()
                );

                $safeName =
                    now()->format('YmdHis') .
                    '-' .
                    Str::random(10) .
                    ($extension ? '.' . $extension : '');

                $path = $file->storePubliclyAs(
                    'form-uploads/' . $form->id,
                    $safeName,
                    'public'
                );

                $data[$fieldName] = $path;

                continue;
            }

            $data[$fieldName] = $request->input($fieldName);
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT
        |--------------------------------------------------------------------------
        */

        $paymentAmount = $this->calculatePaymentAmount(
            $form,
            $request
        );

        $paymentMethod =
            $request->input('metode_pembayaran')
            ?? $request->input('payment_method');

        $paymentProof =
            $data['bukti_pembayaran']
            ?? $data['payment_proof']
            ?? null;

        $paymentStatus = 'unpaid';

        if ($form->payment_enabled && $paymentProof) {
            $paymentStatus = 'verification';
        }

        if (! $form->payment_enabled) {
            $paymentAmount = 0;
            $paymentStatus = 'unpaid';
        }

        /*
        |--------------------------------------------------------------------------
        | SUBMITTER
        |--------------------------------------------------------------------------
        */

        $submitterName =
            $request->input('nama_lengkap')
            ?? $request->input('nama')
            ?? $request->input('submitter_name');

        $submitterEmail =
            $request->input('email')
            ?? $request->input('submitter_email');

        $submitterPhone =
            $request->input('nomor_whatsapp')
            ?? $request->input('whatsapp')
            ?? $request->input('submitter_phone');

        /*
        |--------------------------------------------------------------------------
        | CREATE SUBMISSION
        |--------------------------------------------------------------------------
        */

        $submission = FormSubmission::create([
            'form_id' => $form->id,

            'reference_number' =>
                FormSubmission::generateReferenceNumber(),

            'submitter_name' => $submitterName,
            'submitter_email' => $submitterEmail,
            'submitter_phone' => $submitterPhone,

            'data' => $data,

            // legacy
            'status' => 'new',

            'registration_status' => 'pending',

            'payment_status' => $paymentStatus,
            'payment_amount' => $paymentAmount,
            'payment_method' => $paymentMethod,
            'payment_proof' => $paymentProof,

            'submitted_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | EMAIL
        |--------------------------------------------------------------------------
        */

        if (
            $form->email_notification_enabled &&
            ! empty($submitterEmail)
        ) {
            try {
                Mail::to($submitterEmail)
                    ->send(
                        new FormSubmissionConfirmation($submission)
                    );
            } catch (\Throwable $e) {
                report($e);
            }
        }

        if ($form->admin_notification_enabled) {
            $adminEmail =
                config('mail.admin_address')
                ?? config('mail.from.address');

            if ($adminEmail) {
                try {
                    Mail::to($adminEmail)
                        ->send(
                            new AdminFormSubmissionNotification(
                                $submission
                            )
                        );
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SUCCESS RESPONSE
        |--------------------------------------------------------------------------
        */

        $successTitle =
            $form->success_title
            ?: 'Formulir Berhasil Dikirim';

        $successMessage =
            $form->success_message
            ?: $form->confirmation_message
            ?: 'Terima kasih, data Anda berhasil dikirim.';

        $successData = [
            'success' => true,
            'success_title' => $successTitle,
            'success_message' => $successMessage,
            'next_instructions' => $form->next_instructions,
            'reference_number' => $submission->reference_number,
            'payment_amount' => $paymentAmount,
            'payment_status' => $paymentStatus,
        ];

        /*
        |--------------------------------------------------------------------------
        | WHATSAPP REDIRECT
        |--------------------------------------------------------------------------
        */

        if (
            $form->open_whatsapp_after_submit &&
            ! empty($form->whatsapp_number)
        ) {
            $number = preg_replace(
                '/[^0-9]/',
                '',
                (string) $form->whatsapp_number
            );

            if (str_starts_with($number, '0')) {
                $number = '62' . substr($number, 1);
            }

            $message =
                $form->whatsapp_message
                ?: 'Halo, saya sudah mengisi formulir ' .
                    $form->title .
                    '. Nomor pendaftaran: ' .
                    $submission->reference_number;

            $whatsappUrl =
                'https://wa.me/' .
                $number .
                '?text=' .
                urlencode($message);

            return redirect()
                ->away($whatsappUrl);
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOM REDIRECT
        |--------------------------------------------------------------------------
        */

        if (! empty($form->redirect_url)) {
            return redirect()->away($form->redirect_url);
        }

        return redirect()
            ->route('public.form.show', $form->slug)
            ->with('form_success', $successData);
    }

    protected function ensureRegistrationAvailable(Form $form): void
    {
        if (
            $form->registration_start &&
            now()->lt($form->registration_start)
        ) {
            abort(
                403,
                'Pendaftaran belum dibuka.'
            );
        }

        if (
            $form->registration_end &&
            now()->gt($form->registration_end)
        ) {
            abort(
                403,
                'Pendaftaran sudah ditutup.'
            );
        }
    }

    protected function conditionSatisfied(
        Request $request,
        FormField $field
    ): bool {
        if (
            ! $field->conditional_enabled ||
            ! $field->conditional_field
        ) {
            return true;
        }

        $actual = $request->input(
            $field->conditional_field
        );

        $expected = $field->conditional_value;

        return match ($field->conditional_operator) {
            '!=' =>
                (string) $actual !== (string) $expected,

            'contains' =>
                is_array($actual)
                    ? in_array($expected, $actual)
                    : str_contains(
                        strtolower((string) $actual),
                        strtolower((string) $expected)
                    ),

            'not_contains' =>
                is_array($actual)
                    ? ! in_array($expected, $actual)
                    : ! str_contains(
                        strtolower((string) $actual),
                        strtolower((string) $expected)
                    ),

            'empty' =>
                blank($actual),

            'not_empty' =>
                filled($actual),

            default =>
                (string) $actual === (string) $expected,
        };
    }

    protected function calculatePaymentAmount(
        Form $form,
        Request $request
    ): float {
        if (! $form->payment_enabled) {
            return 0;
        }

        $basePrice =
            (float) (
                $form->promo_price > 0
                    ? $form->promo_price
                    : $form->payment_amount
            );

        $variations = $form->price_variations;

        if (is_string($variations)) {
            $decoded = json_decode($variations, true);

            $variations = is_array($decoded)
                ? $decoded
                : [];
        }

        if (! is_array($variations)) {
            $variations = [];
        }

        /*
         * Mendukung beberapa format variation:
         *
         * [
         *   ['value' => 'XL', 'price' => 220000],
         * ]
         *
         * atau:
         *
         * [
         *   ['label' => 'XL', 'price' => 220000],
         * ]
         */

        foreach ($form->fields as $field) {
            if (! $field->is_price_field) {
                continue;
            }

            $selected = $request->input($field->name);

            if ($selected === null) {
                continue;
            }

            foreach ($variations as $variation) {
                if (! is_array($variation)) {
                    continue;
                }

                $variationValue =
                    $variation['value']
                    ?? $variation['option']
                    ?? $variation['label']
                    ?? $variation['name']
                    ?? null;

                if (
                    (string) $variationValue ===
                    (string) $selected
                ) {
                    $variationPrice =
                        $variation['price']
                        ?? $variation['amount']
                        ?? null;

                    if (
                        $variationPrice !== null &&
                        is_numeric($variationPrice)
                    ) {
                        $basePrice =
                            (float) $variationPrice;
                    }

                    break 2;
                }
            }
        }

        /*
         * Untuk Open PO, jika tersedia field jumlah_jaket,
         * nominal dikalikan jumlah pesanan.
         */

        if ($form->category === 'jacket_po') {
            $quantity =
                (int) $request->input(
                    'jumlah_jaket',
                    1
                );

            $quantity = max(1, $quantity);

            $basePrice *= $quantity;
        }

        return max(0, $basePrice);
    }
}
