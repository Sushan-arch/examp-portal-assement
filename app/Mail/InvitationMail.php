<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * InvitationMail
 */
class InvitationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * questionnaire
     *
     * @var mixed
     */
    public $questionnaire;

    /**
     * Create a new message instance.
     */
    public function __construct($questionnaire)
    {
        $this->afterCommit();
        $this->questionnaire = $questionnaire;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Questionnaire Prepare Invitation Mail'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation', // Blade template for the email content
            with: [
                'questionnaire' => $this->questionnaire['questionnaire'],
                'studentName' => $this->questionnaire['studentName'],
                'uniqueGeneratedUrl' => $this->questionnaire['generatedUrl']
            ] // Pass questionnaire data to the view
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
