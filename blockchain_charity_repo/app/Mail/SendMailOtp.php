<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailOtp extends Mailable
{
    use Queueable, SerializesModels;

    private $otp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Otp login')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('auth.mail_otp', ['otp' => $this->otp]);
    }
}
