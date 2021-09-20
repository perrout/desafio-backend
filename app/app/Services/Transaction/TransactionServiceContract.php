<?php

namespace App\Services\Transaction;

interface TransactionServiceContract
{
    public function createTransfer(array $data);
    public function handleTransfer(array $data);
}
