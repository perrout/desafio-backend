<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepositoryContract;

class TransactionRepository implements TransactionRepositoryContract
{
    private $model;

    public function __construct()
    {
        $this->model = new Transaction;
    }

    public function transfer(array $data)
    {
        return $this->model->create($data);
    }

    public function changeStatus($transactionId, $status)
    {
        $transaction = $this->model->findOrFail($transactionId);
        return $transaction->update(['status' => $status]);
    }
}
