<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OnboardSubMerchant extends Mailable
{
    use Queueable, SerializesModels;

    protected $subMerchant;
    protected $merchant;
    /**
     * Create a new message instance.
     */
    public function __construct($subMerchant, $merchant)
    {
        $this->subMerchant = $subMerchant;
        $this->merchant = $merchant;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to ' . $this->merchant->name . ' - Complete Your Onboarding Process',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.onboard-submerchant',
            with: [
            'subMerchant' => $this->subMerchant,
            'merchant' => $this->merchant,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
