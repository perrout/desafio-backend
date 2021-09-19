<?php

namespace App\Services\Transaction;

use App\Jobs\Transaction\ProcessTransfer;
use App\Repositories\Users\UsersRepositoryContract;
use App\Repositories\Transaction\TransactionRepositoryContract;
use App\Services\Transaction\TransactionServiceContract;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceContract
{
    private $transactionRepository;
    private $usersRepository;

    public function __construct(TransactionRepositoryContract $transactionRepository, UsersRepositoryContract $usersRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->usersRepository = $usersRepository;
    }

    public function createTransfer(array $data)
    {
        $transfer = $this->transactionRepository->transfer($data);
        ProcessTransfer::dispatch($transfer);
        return $transfer;
    }

    public function handleTransfer(object $data)
    {
        DB::beginTransaction();
        try {
            $payer = $this->usersRepository->findById($data->payer_id);
            $payee = $this->usersRepository->findById($data->payee_id);
            $this->usersRepository->update($data->payer_id, ['wallet' => $payer->wallet -= floatval($data->value)]);
            $this->usersRepository->update($data->payee_id, ['wallet' => $payee->wallet += floatval($data->value)]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }
}
