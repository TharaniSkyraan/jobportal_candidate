<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangePasswordRequestMailable extends Mailable
{

    use SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;

        return $this->from(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->replyTo(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->to($user->email, $user->getName())
                        ->subject('Profile update verification')
                        ->markdown('emails.change_password_verification')
                        ->with(
                                [
                                    'user_name' => $user->getName(),
                                    'otp' => $user->verification_token
                                 ]
        );
    }

}
