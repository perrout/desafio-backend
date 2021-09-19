<?php

namespace App\Repositories\Transaction;

interface TransactionRepositoryContract
{
    public function transfer(array $data);

    public function setStatusCompleted($transactionId);

    public function setStatusFailed($transactionId);

    public function changeStatus($transactionId, $status);

}
