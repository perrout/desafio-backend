<?php

namespace App\Providers\Transaction;

use App\Repositories\Contracts\TransactionRepositoryContract;
use App\Repositories\TransactionRepository;
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
