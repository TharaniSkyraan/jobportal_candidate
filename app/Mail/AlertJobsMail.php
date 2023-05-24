<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertJobsMail extends Mailable
{

    use Queueable,
        SerializesModels;

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
        return $this->to(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        // ->to($this->data['email'], $this->data['email'])
                        ->subject('test')
                        ->markdown('emails.send_job_alerts')
                        ->with('subject','test')
                        ->with('jobs',$this->data);
    }

}
