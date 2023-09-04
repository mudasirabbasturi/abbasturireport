<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\sendEmail;
use Mail;


class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $notificationEmail;
    protected $subject;
    protected $title;
    protected $address;
    protected $bodytext;
    protected $url;

    /**
     * Create a new job instance.
     */
    public function __construct($notificationEmail, $subject, $title, $address,  $bodytext, $url)
    {
        $this->notificationEmail = $notificationEmail;
        $this->subject = $subject;
        $this->title = $title;
        $this->address = $address;
        $this->bodytext = $bodytext;
        $this->url = $url;
    }

    /**
     * Execute the job.
     */

    public function handle(): void
    {
        $email = new sendEmail(
                                 $this->subject, 
                                 $this->title, 
                                 $this->address,
                                 $this->bodytext,
                                 $this->url);
        Mail::to($this->notificationEmail)->send($email);
    }

}

