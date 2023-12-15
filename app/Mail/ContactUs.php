<?php


namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
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
        $emailscc = array('ravindhiran@skyraan.com');
        array_push($emailscc, 'gnanamaruthu@skyraan.com');
        return $this->from($data->email, $data->name)
                        ->replyTo($data->email, $data->name)
                        ->cc($emailscc)
                        ->to(config('mail.support_recieve_to.address'), config('mail.support_recieve_to.name'))
                        ->subject($data->subject)
                        ->markdown('emails.send_contact_message')
                        ->with(['data'=>$data]);
    }

}
