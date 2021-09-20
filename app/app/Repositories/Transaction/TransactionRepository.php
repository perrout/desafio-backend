<?php

namespace App\Repositories\Transaction;

use App\Exceptions\CustomException;
use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepositoryContract;
use App\Repositories\Users\UsersRepositoryContract;
use App\Services\Notification\NotificationServiceContract;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionRepositoryContract
{
    private $model;
    private $notificationService;
    private $usersRepository;

    public function __construct(UsersRepositoryContract $usersRepository, NotificationServiceContract $notificationService)
    {
        $this->model = new Transaction;
        $this->notificationService = $notificationService;
        $this->usersRepository = $usersRepository;
    }

    public function createTransfer(array $data)
    {
        return $this->model->create($data);
    }

    public function revertTransfer(int $transactionId)
    {
        DB::beginTransaction();
        try {
            $transaction = $this->model->reversible()->findOrFail($transactionId);
            $this->usersRepository->increaseBalance($transaction->payer_id, $transaction->value);
            $this->usersRepository->decreaseBalance($transaction->payee_id, $transaction->value);
            $transaction->update(['status' => 'canceled']);
            DB::commit();
            return $transaction;
        } catch (Exception $e) {
            DB::rollback();
            if ($e instanceof ModelNotFoundException) {
                throw new CustomException("This transaction is not reversible.", 422);
            }
            throw $e;
        }
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
        if ($transaction->update(['status' => 'completed'])) {
            $notificationData = [
                'transaction_id' => $transaction->id,
                'data' => $transaction->toJson()
            ];
            $this->notificationService->createNotitication($notificationData);
            return true;
        }
        return false;
    }

    public function setStatusFailed($transactionId)
    {
        $transaction = $this->model->findOrFail($transactionId);
        return $transaction->update(['status' => 'failed']);
    }
}
