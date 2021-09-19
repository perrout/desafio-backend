<?php

namespace App\Providers\Authorization;

use App\Services\Authorization\AuthorizationService;
use App\Services\Authorization\AuthorizationServiceContract;
use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
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
            AuthorizationServiceContract::class,
            AuthorizationService::class
        );
    }
}
