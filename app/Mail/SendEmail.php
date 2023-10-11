<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $information,$reply_email,$name;

    public function __construct($information,$reply_email,$name)
    {
        $this->information = $information;

        $this->reply_email = $reply_email;

        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(env("APP_NAME"))->view("mail.message_file")->replyTo($this->reply_email, $this->name);
        ;
    }
}
