<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobAppliedCompanyMailable extends Mailable
{

    use SerializesModels;

    public $job;
    public $jobApply;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job, $jobApply)
    {
        $this->job = $job;
        $this->jobApply = $jobApply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $company = $this->job->getCompany();
        $user = $this->jobApply->getUser();
        // $contact = $this->job->contact_person_details();
        // $emailscc = array($contact->email);
        // for ($i = 1; $i <= 5; $i++) {
        //     $email = 'shared_email_'.$i;
        //     if(!empty($contact->$email)){
        //         array_push($emailscc, $contact->$email);
        //     }
        // }

        return $this->from(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->replyTo(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                        ->to($company->email, $company->name)
                        // ->cc($emailscc)
                        ->subject($this->job->title . ' candidate - ' . $user->getName() . ' applied on ' . config('app.name'))
                        ->markdown('emails.job_applied_company_message')
                        ->with([
                                    'company_name' => $company->name,
                                    'user_name' => $user->getName(),
                                    'user_link' =>route('applicant-profile', $this->jobApply->id),
                                    'job_link' => route('job.detail', [$this->job->slug])
                                ]);
    }

}
