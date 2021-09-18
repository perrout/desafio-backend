<?php

namespace App\Repositories\Users;

interface UsersRepositoryContract
{
    public function all();

    public function findById($userId);

    public function update($userId, array $data);

    public function destroy($userId);

    public function isCommon($userId);

    public function getWallet($userId);
}
