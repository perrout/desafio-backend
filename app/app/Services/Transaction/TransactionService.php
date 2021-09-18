<?php

namespace App\Services\Transaction;

use App\Repositories\Transaction\TransactionRepositoryContract;
use App\Services\Transaction\TransactionServiceContract;

class TransactionService implements TransactionServiceContract
{
    private $repository;

    public function __construct(TransactionRepositoryContract $transactionRepository)
    {
        $this->repository = $transactionRepository;
    }

    public function createTransfer(array $data)
    {
        $transfer = $this->repository->transfer($data);
        return $transfer;
    }
}
