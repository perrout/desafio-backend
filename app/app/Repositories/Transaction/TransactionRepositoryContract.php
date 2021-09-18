<?php

namespace App\Repositories\Transaction;

interface TransactionRepositoryContract
{
    public function transfer(array $data);
    public function changeStatus($transactionId, $status);

}
