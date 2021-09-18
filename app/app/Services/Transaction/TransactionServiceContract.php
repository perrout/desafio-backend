<?php

namespace App\Services\Transaction;

interface TransactionServiceContract
{
    public function createTransfer(array $data);
}
