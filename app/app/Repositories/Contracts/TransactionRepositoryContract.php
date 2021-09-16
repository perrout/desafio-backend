<?php

namespace App\Repositories\Contracts;

interface TransactionRepositoryContract
{
    public function transfer(array $data);
    public function changeStatus($transactionId, $status);

}
