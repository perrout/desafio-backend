<?php

namespace App\Services\Transaction;

use App\Jobs\Transaction\ProcessTransfer;
use App\Repositories\Users\UsersRepositoryContract;
use App\Repositories\Transaction\TransactionRepositoryContract;
use App\Services\Authorization\AuthorizationServiceContract;
use App\Services\Transaction\TransactionServiceContract;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceContract
{
    private $authorizationService;
    private $transactionRepository;
    private $usersRepository;

    public function __construct(TransactionRepositoryContract $transactionRepository, UsersRepositoryContract $usersRepository, AuthorizationServiceContract $authorizationService)
    {
        $this->transactionRepository = $transactionRepository;
        $this->usersRepository = $usersRepository;
        $this->authorizationService = $authorizationService;
    }

    public function createTransfer(array $data)
    {
        $transfer = $this->transactionRepository->transfer($data);
        ProcessTransfer::dispatch($transfer, $this->authorizationService)->delay(now()->addMinutes(1));
        return $transfer;
    }

    public function handleTransfer(array $data)
    {
        DB::beginTransaction();
        try {
            $this->usersRepository->decreaseBalance($data['payer_id'], $data['value']);
            $this->usersRepository->increaseBalance($data['payee_id'], $data['value']);
            $this->transactionRepository->setStatusCompleted($data['id']);
            DB::commit();
        } catch (Exception $e) {
            $this->transactionRepository->setStatusFailed($data['id']);
            DB::rollback();
        }
    }
}
