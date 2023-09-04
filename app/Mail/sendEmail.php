<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $title;
    public $address;
    public $bodytext;
    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $title, $address, $bodytext, $url)
    {
        $this->subject = $subject;
        $this->title = $title;
        $this->address = $address;
        $this->bodytext = $bodytext;
        $this->url = $url;
    }


    /**
     * Get the message content definition.
     */

     public function build() {

        return $this->subject($this->subject)
                    ->view('emails.send-email')
                    ->with([
                            'title'   => $this->title,
                            'address' => $this->address,
                            'bodytext' => $this->bodytext,
                            'url' => $this->url,
                           ]);
     }

    /**
     * Get the attachments for the message.  send-email
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
