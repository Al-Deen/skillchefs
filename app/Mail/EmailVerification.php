<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
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

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $data['user'] = $this->data;
        $data['url']  = route('frontend.verify_email',['email' => encrypt($this->data->email)]) . '?expire=' . strtotime(now()->addMinutes(30));
        return $this
        ->subject(___('email.Email Verification'))
        ->view('common.email.email-verification', compact('data'));
    }
}
