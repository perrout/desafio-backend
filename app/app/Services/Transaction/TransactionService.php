<?php

namespace App\Services\Transaction;

use App\Jobs\Transaction\ProcessTransfer;
use App\Repositories\Users\UsersRepositoryContract;
use App\Repositories\Transaction\TransactionRepositoryContract;
use App\Services\Authorization\AuthorizationServiceContract;
use App\Services\Transaction\TransactionServiceContract;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceContract
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryContract $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function createTransfer(array $transaction)
    {
        return $this->transactionRepository->createTransfer($transaction);
    }

    public function handleTransfer(array $transaction)
    {
        if ($this->transactionRepository->handleTransfer($transaction)) {
            return $this->transactionRepository->setStatusCompleted($transaction['id']);
        }

        return $this->transactionRepository->setStatusFailed($transaction['id']);
    }
}
