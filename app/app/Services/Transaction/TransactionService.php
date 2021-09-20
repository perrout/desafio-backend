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
    private $authorizationService;
    private $transactionRepository;

    public function __construct(TransactionRepositoryContract $transactionRepository, AuthorizationServiceContract $authorizationService)
    {
        $this->transactionRepository = $transactionRepository;
        $this->authorizationService = $authorizationService;
    }

    public function createTransfer(array $transaction)
    {
        $transfer = $this->transactionRepository->createTransfer($transaction);
        ProcessTransfer::dispatch($transfer, $this->authorizationService);
        // ProcessTransfer::dispatch($transfer, $this->authorizationService)->delay(now()->addMinutes(1));
        return $transfer;
    }

    public function handleTransfer(array $transaction)
    {
        if ($this->transactionRepository->handleTransfer($transaction)) {
            return $this->transactionRepository->setStatusCompleted($transaction['id']);
        }

        return $this->transactionRepository->setStatusFailed($transaction['id']);

    }
}
