<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepositoryContract;
use App\Repositories\Users\UsersRepositoryContract;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class TransactionRepository implements TransactionRepositoryContract
{
    private $model;
    private $usersRepository;

    public function __construct(UsersRepositoryContract $usersRepository)
    {
        $this->model = new Transaction;
        $this->usersRepository = $usersRepository;
    }

    public function createTransfer(array $data)
    {
        return $this->model->create($data);
    }

    public function handleTransfer(array $data)
    {
        DB::beginTransaction();
        try {
            $this->usersRepository->decreaseBalance($data['payer_id'], $data['value']);
            $this->usersRepository->increaseBalance($data['payee_id'], $data['value']);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            report($e);
            return false;
        }
    }

    public function setStatusCompleted($transactionId)
    {
        $transaction = $this->model->findOrFail($transactionId);
        return $transaction->update(['status' => 'completed']);
    }

    public function setStatusFailed($transactionId)
    {
        $transaction = $this->model->findOrFail($transactionId);
        return $transaction->update(['status' => 'failed']);
    }
}
