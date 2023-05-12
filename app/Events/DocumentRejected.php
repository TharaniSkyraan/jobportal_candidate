<?php

namespace App\Events;

use App\Model\Company;
use App\Model\Job;
use Illuminate\Queue\SerializesModels;

class DocumentRejected
{

    use SerializesModels;

    public $company;
    public $job;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( Company $company,Job $job)
    {
        $this->job = $job;
        $this->company = $company;
    }

}
