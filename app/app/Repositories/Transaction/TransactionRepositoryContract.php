<?php

namespace App\Repositories\Transaction;

interface TransactionRepositoryContract
{
    public function createTransfer(array $data);

    public function handleTransfer(array $data);

    public function setStatusCompleted($transactionId);

    public function setStatusFailed($transactionId);

}
