<?php

namespace App\Events;

use App\Model\Company;
use Illuminate\Queue\SerializesModels;

class DocumentVerified
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
