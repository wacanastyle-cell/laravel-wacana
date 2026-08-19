<?php

namespace App\Mail;

use App\Models\FormSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminFormSubmissionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public FormSubmission $submission,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Submisi Baru: ' . ($this->submission->form->title ?? 'Formulir') . ' - Wacana Style',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-form-submission',
        );
    }
}