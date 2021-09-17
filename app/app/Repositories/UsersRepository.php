<?php

namespace App\Repositories;

use App\Http\Requests\UsersRequest;
use App\Models\User;
use App\Repositories\Contracts\UsersRepositoryContract;

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
        return ($user->type === 'common') ?: false;
    }
}
