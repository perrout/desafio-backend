<?php

namespace App\Repositories\Transaction;

interface TransactionRepositoryContract
{
    public function createTransfer(array $data);

    public function revertTransfer(int $transactionId);

    public function handleTransfer(array $data);

    public function setStatusCompleted($transactionId);

    public function setStatusFailed($transactionId);

}
