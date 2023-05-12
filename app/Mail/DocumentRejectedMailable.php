<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentRejectedMailable extends Mailable
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
   
        return $this->to(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->subject('Document Required')
                        ->markdown('emails.document_rejected_message')
                        ->with([
                                'title' => $this->job->title,
                                'name' => $this->company->name,
                                'email' => $this->company->email,
                                'link' => "{{ route('company_profile') }}#document",
                                'website_link' => "{{ url('/') }}",
                            ]);
    }

}
