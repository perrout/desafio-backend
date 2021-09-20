<?php

namespace App\Jobs\Transaction;

use App\Models\Transaction;
use App\Services\Authorization\AuthorizationServiceContract;
use App\Services\Transaction\TransactionServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTransfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $authorization;
    private $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, AuthorizationServiceContract $authorization)
    {
        $this->transaction = $transaction;
        $this->authorization = $authorization;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TransactionServiceContract $transactionService)
    {
        if ($this->authorization->status()) {
            $transactionService->handleTransfer($this->transaction->toArray());
        }
    }
}
