<?php

namespace App\Mail;

use App\Models\FormSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormSubmissionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public FormSubmission $submission,
        public bool $isStatusUpdate = false,
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->isStatusUpdate
            ? 'Status formulir Anda telah diperbarui - Wacana Style'
            : 'Formulir Anda berhasil diterima - Wacana Style';

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.form-submission',
        );
    }
}