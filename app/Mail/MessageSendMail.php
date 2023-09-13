<?php


namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageSendMail extends Mailable
{

    use SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        return $this->from($data['company_email'], $data['company_name'])
                        ->replyTo($data['company_email'], $data['company_name'])
                        ->to(config('mail.support_recieve_to.address'), config('mail.support_recieve_to.name'))
                        ->subject('New message received from '.$data['user_name'].' for '.$data['job_title'])
                        ->markdown('emails.send_message')
                        ->with(['data'=>$data]);
    }

}
