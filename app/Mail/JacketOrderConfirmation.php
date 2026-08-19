<?php

namespace App\Mail;

use App\Models\JacketOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JacketOrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public JacketOrder $order,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pesanan Jaket Anda Telah Diterima - Wacana Style',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.jacket-order-confirmation',
        );
    }
}
