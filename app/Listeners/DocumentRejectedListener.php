<?php

namespace App\Listeners;

use Mail;
use App\Events\DocumentRejected;
use App\Mail\DocumentRejectedMailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DocumentRejectedListener implements ShouldQueue
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
    public function handle(DocumentRejected $event)
    {
        Mail::send(new DocumentRejectedMailable($event->company,$event->job));
    }

}
