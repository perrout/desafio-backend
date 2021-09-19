<?php

namespace App\Providers\Users;

use App\Repositories\Users\UsersRepository;
use App\Repositories\Users\UsersRepositoryContract;
use App\Services\Users\UsersService;
use App\Services\Users\UsersServiceContract;
use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            UsersRepositoryContract::class,
            UsersRepository::class
        );

        $this->app->bind(
            UsersServiceContract::class,
            UsersService::class
        );
    }
}
