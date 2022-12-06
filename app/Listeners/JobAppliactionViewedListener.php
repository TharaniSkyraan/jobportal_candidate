<?php

namespace App\Listeners;

use Mail;
use App\Events\ApplicationViewed;
use App\Mail\JobAppliactionViewedMailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobAppliactionViewedListener implements ShouldQueue
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CompanyRegistered  $event
     * @return void
     */
    public function handle(ApplicationViewed $event)
    {
        // Mail::send(new JobAppliactionViewedMailable($event->job, $event->jobApply));
    }

}
