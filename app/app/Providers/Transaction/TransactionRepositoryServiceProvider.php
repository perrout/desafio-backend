<?php

namespace App\Providers\Transaction;

use App\Repositories\Contracts\TransactionRepositoryContract;
use App\Repositories\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class TransactionRepositoryServiceProvider extends ServiceProvider
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
            TransactionRepositoryContract::class,
            TransactionRepository::class
        );
    }
}
