<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserRegistered' => [
            'App\Listeners\UserRegisterdListener',
        ],
        'App\Events\CompanyRegistered' => [
            'App\Listeners\CompanyRegisterdListener',
        ],
        'App\Events\JobPosted' => [
            'App\Listeners\JobPostedListener',
        ],
        'App\Events\JobStatusUpdate' => [
            'App\Listeners\JobStatusUpdateListener',
        ],
        'App\Events\JobApplied' => [
            'App\Listeners\JobAppliedCompanyListener',
        ],
        'App\Events\ApplicationViewed' => [
            'App\Listeners\JobAppliactionViewedListener',
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // ... other providers
            \SocialiteProviders\Apple\AppleExtendSocialite::class.'@handle',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }

}
