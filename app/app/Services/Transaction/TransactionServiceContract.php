<?php

namespace App\Services\Transaction;

interface TransactionServiceContract
{
    public function createTransfer(array $transaction);

    public function revertTransfer(int $transactionId);

    public function handleTransfer(array $transaction);
}
