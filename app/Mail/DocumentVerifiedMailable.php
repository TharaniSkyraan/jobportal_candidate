<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentVerifiedMailable extends Mailable
{

    use SerializesModels;

    public $company;
    public $job;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company=null,$job)
    {
        $this->company = $company;
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
   
        return $this->from(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->to($this->company->email, $this->company->name)
                        ->subject('Document Required')
                        ->markdown('emails.document_verified_message')
                        ->with(
                            [
                                'title' => $this->job->title,
                                'name' => $this->company->name,
                                'email' => $this->company->email,
                                'link' => "#",
                            ]);
    }

}
