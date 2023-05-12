<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUserMailable extends Mailable
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
        return $this->to(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->subject('Welcome on ' . config('app.name'))
                        ->markdown('emails.welcome_user_message')
                        ->with(
                        [
                            'name' => $this->user->getName(),
                            'email' => $this->user->email,
                     
                        ]);
    }

}
