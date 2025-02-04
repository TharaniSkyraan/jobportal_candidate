<?php

namespace App\Events;

use App\Model\Job;
use App\Model\JobApply;
use Illuminate\Queue\SerializesModels;

class JobApplied
{

    use SerializesModels;

    public $job;
    public $jobApply;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Job $job, JobApply $jobApply)
    {
        $this->job = $job;
        $this->jobApply = $jobApply;
    }

}
