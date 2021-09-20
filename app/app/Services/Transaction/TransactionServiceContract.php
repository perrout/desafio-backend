<?php

namespace App\Services\Transaction;

interface TransactionServiceContract
{
    public function createTransfer(array $transaction);
    public function handleTransfer(array $transaction);
}
