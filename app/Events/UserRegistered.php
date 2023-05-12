<?php

namespace App\Events;

use App\Model\User;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{

    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        \Log::info($user);
        $this->user = $user;
        
    }

}
