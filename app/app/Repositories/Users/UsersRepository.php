<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Repositories\Users\UsersRepositoryContract;

class UsersRepository implements UsersRepositoryContract
{
    private $model;

    public function __construct()
    {
        $this->model = new User;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function findById($userId)
    {
        return $this->model->findOrFail($userId);
    }

    public function update($userId, array $data)
    {
        $user = $this->findById($userId);
        $user->update($data);
        return $user;
    }

    public function destroy($userId)
    {
        $user = $this->findById($userId);
        if ($user->delete()) {
            return 'success';
        }
        return 'fail';
    }

    public function isCommon($userId)
    {
        $user = $this->findById($userId);
        return $user->type === 'common';
    }

    public function getWallet($userId)
    {
        $user = $this->findById($userId);
        return $user->wallet ?: 0;
    }

    public function hasBalance($userId, $value)
    {
        if ($this->getWallet($userId) >= $value) {
            return true;
        }
        return false;
    }

    public function increaseBalance($userId, $value)
    {
        $user = $this->findById($userId);
        $user->update([
            'wallet' => $user->wallet += floatval($value)
        ]);
        return $user;
    }

    public function decreaseBalance($userId, $value)
    {
        $user = $this->findById($userId);
        $user->update([
            'wallet' => $user->wallet -= floatval($value)
        ]);
        return $user;
    }
}
