<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\Transaction;
use App\Observers\Notification\NotificationObserver;
use App\Observers\Transaction\TransactionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Notification::observe(NotificationObserver::class);
        Transaction::observe(TransactionObserver::class);
    }
}
