<?php

namespace App\Listeners;

use Mail;
use App\Events\DocumentVerified;
use App\Mail\DocumentVerifiedMailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DocumentVerifiedListener implements ShouldQueue
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
    public function handle(DocumentVerified $event)
    {
        Mail::send(new DocumentVerifiedMailable($event->company,$event->job));
    }

}
