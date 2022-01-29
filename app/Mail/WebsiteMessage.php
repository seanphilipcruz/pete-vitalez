<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebsiteMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $website_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($website_message)
    {
        $this->website_message = $website_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Website Message')
            ->view('email.message');
    }
}
