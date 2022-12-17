<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Village;

class EndPhaseEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $member;
    protected $end_phase_name;
    protected $village;
    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Member $member, $end_phase_name, Village $village, $url)
    {
        $this->member = $member;
        $this->end_phase_name = $end_phase_name;
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
            subject: '【Tachi-No-Voice】'.$this->end_phase_name.'フェーズが終了しました',
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
            view: 'emails.end_phase_email',
            with: [
                'Name' => $this->member->name(),
                'next_phase_name' => $this->village->phase()->phaseName(),
                'end_phase_name' => $this->end_phase_name,
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
