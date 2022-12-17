<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Village;

class NextPhaseEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $member;
    protected $village;
    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Member $member, Village $village, $url)
    {
        $this->member = $member;
        $this->village = $village;
        $this->url = $url;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: '【Tachi-No-Voice】'.$this->village->phase()->phaseName().'フェーズが開始しました。',
            from: 'foo@example.net',
            to: $this->member->email(),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.next_phase_email',
            with: [
                'Name' => $this->member->name(),
                'next_phase_name' => $this->village->phase()->phaseName(),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
