<?php

namespace App\Services\Users;

use App\Repositories\Users\UsersRepositoryContract;
use App\Services\Users\UsersServiceContract;

class UsersService implements UsersServiceContract
{
    private $repository;

    public function __construct(UsersRepositoryContract $usersRepository)
    {
        $this->repository = $usersRepository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function show($userId)
    {
        return $this->repository->findById($userId);
    }

    public function update($userId, array $data)
    {
        $user = $this->repository->findById($userId);
        $user->update($data);
        return $user;
    }

    public function destroy($userId)
    {
        $user = $this->repository->findById($userId);
        if ($user->delete()) {
            return 'success';
        }
        return 'fail';
    }

    public function isCommon($userId)
    {
        $user = $this->repository->findById($userId);
        return $user->type === 'common';
    }

    public function getWallet($userId)
    {
        $user = $this->repository->findById($userId);
        return $user->wallet ?: 0;
    }
}
