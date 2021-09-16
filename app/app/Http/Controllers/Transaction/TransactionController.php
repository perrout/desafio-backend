<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Repositories\Contracts\TransactionRepositoryContract;
use Exception;
use Throwable;

class TransactionController extends Controller
{
    private $repository;

    public function __construct(TransactionRepositoryContract $transactionRepository)
    {
        $this->repository = $transactionRepository;
    }

    public function transfer(TransactionRequest $request)
    {
        try{
            $data = $request->safe()->only([
                'payer_id',
                'payee_id',
                'value'
            ]);
            $transaction = $this->repository->transfer($data);
            $response = [
                'status' => true,
                'data' => $transaction
            ];
            return response()->json($response);
        } catch (Exception | Throwable $e) {
            $response = [
                'status' => false,
                'error' => $e->getMessage()
            ];
            return response()->json($response, $e->getCode());
        }
    }

}
