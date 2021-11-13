<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $code;
    protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name, $code)
    {
        $this->email = $email;
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'applications@gulderultimatesearch.ng';
        $welcome_name = 'Gulder Ultimate Search';
        $subject = 'Email Verification Code';

        return $this->markdown('email.email_verification')
            ->from($address, $welcome_name)
            ->subject($subject)
            ->with([
                'name'  => $this->name,
                'email' => $this->email,
                'code' => $this->code
            ]);
    }
}
