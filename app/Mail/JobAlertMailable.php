<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobAlertMailable extends Mailable
{

    use SerializesModels;

    public $jobalert, $jobs, $slug, $limit;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobalert, $jobs, $slug, $limit)
    {
        $this->jobalert = $jobalert;
        $this->jobs = $jobs;
        $this->slug = $slug;
        $this->limit = $limit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->jobalert->user;
        
        \Log::info("user!".json_encode($user));


        return $this->from(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                    ->replyTo(config('mail.recieve_to.address'), config('mail.recieve_to.name'))
                    ->to($user->email, $user->getName())
                    ->subject('New job vaccancies for '. $this->jobalert->title . config('app.name'))
                    ->markdown('emails.job_alert')
                    ->with([
                            'jobalert' => $this->jobalert,
                            'jobs' => $this->jobs,
                            'slug' => $this->slug,
                            'limit' => $this->limit
                        ]);
    }

}
