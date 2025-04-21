<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayoutRejectMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $data['payout'] = $this->data;
        return $this
            ->subject(___('email.Payout Rejected'))
            ->view('common.email.reject_payout', compact('data'));
    }
}
