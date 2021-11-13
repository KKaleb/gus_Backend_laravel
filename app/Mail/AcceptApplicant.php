<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptApplicant extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $barcode;
    protected $address;
    protected $time;
    protected $batch;
    protected $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $barcode, $address, $time, $batch, $date)
    {
        $this->user = $user;
        $this->barcode = $barcode;
        $this->address = $address;
        $this->time = $time;
        $this->batch = $batch;
        $this->date = $date;
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
        $subject = 'Congratulation Message ';

        return $this->markdown('email.accept')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'first_name'               => $this->user->first_name,
                'last_name'               => $this->user->last_name,
                'venue'                 => $this->user->audition_location,
                'barcode'                  => $this->barcode,
                'address'                  => $this->address,
                'time'                  => $this->time,
                'batch'                  => $this->batch,
                'date'                  => $this->date
            ]);
    }
}
