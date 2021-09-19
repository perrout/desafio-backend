<?php

namespace App\Providers\Transaction;

use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\TransactionRepositoryContract;
use App\Services\Transaction\TransactionService;
use App\Services\Transaction\TransactionServiceContract;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
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
            TransactionRepositoryContract::class,
            TransactionRepository::class
        );

        $this->app->bind(
            TransactionServiceContract::class,
            TransactionService::class
        );
    }
}
