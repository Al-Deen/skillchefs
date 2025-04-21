<?php

namespace App\Providers;

use App\Events\MakePayoutEvent;
use App\Events\PayoutRejectEvent;
use App\Events\ForgotPasswordEvent;
use App\Events\UserEmailVerifyEvent;
use App\Events\EmailSendEvent;
use App\Listeners\MakePayoutListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Events\ApiUserEmailVerifyEvent;
use App\Listeners\PayoutRejectListener;
use App\Listeners\ForgotPasswordListener;
use App\Listeners\UserEmailVerifyListener;
use App\Listeners\EmailSendListener;
use App\Events\AdminEmailVerificationEvent;
use App\Listeners\ApiUserEmailVerifyListener;
use App\Listeners\AdminEmailVerificationListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserEmailVerifyEvent::class => [
            UserEmailVerifyListener::class,
        ],
        ApiUserEmailVerifyEvent::class => [
            ApiUserEmailVerifyListener::class,
        ],
        AdminEmailVerificationEvent::class => [
            AdminEmailVerificationListener::class,
        ],
        ForgotPasswordEvent::class => [
            ForgotPasswordListener::class,
        ],
        PayoutRejectEvent::class => [
            PayoutRejectListener::class,
        ],
        MakePayoutEvent::class => [
            MakePayoutListener::class,
        ],
        EmailSendEvent::class => [
            EmailSendListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
