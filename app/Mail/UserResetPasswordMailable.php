<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserResetPasswordMailable extends Mailable
{

    use SerializesModels;

    public $email, $token, $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token=null, $email=null, $name=null)
    {
        $this->email = $email;
        $this->token = $token;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
   
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->to($this->email, $this->name)
                    ->subject('Password Reset')
                    ->markdown('vendor.notifications.reset-password')
                    ->with([
                                'link' => 'https://mugaam.com/password/reset/'.$this->token.'?email='.$this->email,
                            ]);
    }

}
