<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Services\Transaction\TransactionServiceContract;
use Exception;

class TransactionController extends Controller
{
    private $service;

    public function __construct(TransactionServiceContract $transactionService)
    {
        $this->service = $transactionService;
    }

    public function transfer(TransactionRequest $request)
    {
        try{
            $data = $request->safe()->only([
                'payer_id',
                'payee_id',
                'value'
            ]);
            $transaction = $this->service->createTransfer($data);
            $response = [
                'status' => true,
                'data' => $transaction
            ];
            return response()->json($response);
        } catch (Exception $e) {
            $response = [
                'status' => false,
                'error' => $e->getMessage()
            ];
            return response()->json($response, $e->getCode());
        }
    }

    public function revert($transactionId)
    {
        try{
            $transaction = $this->service->revertTransfer($transactionId);
            $response = [
                'status' => true,
                'data' => $transaction
            ];
            return response()->json($response);
        } catch (Exception $e) {
            $response = [
                'status' => false,
                'error' => $e->getMessage()
            ];
            return response()->json($response, $e->getCode());
        }
    }

}
