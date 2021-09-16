<?php

namespace App\Providers\Users;

use App\Repositories\Contracts\UsersRepositoryContract;
use App\Repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

class UsersRepositoryServiceProvider extends ServiceProvider
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
    }
}
