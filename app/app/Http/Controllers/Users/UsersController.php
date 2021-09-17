<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Repositories\Contracts\UsersRepositoryContract;
use Exception;

class UsersController extends Controller
{
    private $repository;

    public function __construct(UsersRepositoryContract $usersRepository)
    {
        $this->repository = $usersRepository;
    }

    public function index()
    {
        try {
            $users = $this->repository->all();
            $response = [
                'status' => true,
                'data' => $users
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

    public function show($userId)
    {
        try {
            $user = $this->repository->findById($userId);
            $response = [
                'status' => true,
                'data' => $user
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

    public function update(UsersRequest $request, $userId)
    {
        try {
            $data = $request->safe()->only([
                'first_name',
                'last_name',
                'document',
                'wallet',
                'email',
                'password',
                'status',
                'type'
            ]);
            $user = $this->repository->update($userId, $data);
            $response = [
                'status' => true,
                'data' => $user
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

    public function destroy($userId)
    {
        try {
            $user = $this->repository->destroy($userId);
            $response = [
                'status' => true,
                'data' => $user
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
