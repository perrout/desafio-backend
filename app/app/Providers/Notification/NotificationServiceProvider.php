<?php

namespace App\Providers\Notification;

use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Notification\NotificationRepositoryContract;
use App\Services\Notification\NotificationServiceContract;
use App\Services\Notification\NotificationService;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            NotificationRepositoryContract::class,
            NotificationRepository::class
        );

        $this->app->bind(
            NotificationServiceContract::class,
            NotificationService::class
        );
    }
}
