<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'applications@gulderultimatesearch.ng';
        $name = 'Gulder Ultimate Search';
        $subject = 'Welcome to Gulder Ultimate Search';

        return $this->markdown('email.welcome')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'first_name'               => $this->user->first_name,
                'last_name'               => $this->user->last_name,
            ]);
    }
}
