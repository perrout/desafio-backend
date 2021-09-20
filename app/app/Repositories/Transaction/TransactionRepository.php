<?php

namespace App\Repositories\Transaction;

use App\Jobs\Notification\SendTransferReceipt;
use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepositoryContract;
use App\Repositories\Users\UsersRepositoryContract;
use App\Services\Notification\NotificationServiceContract;
use Exception;
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
            $notification = $this->notificationService->createNotitication($notificationData);

            SendTransferReceipt::dispatch($notification, $this->notificationService);
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
