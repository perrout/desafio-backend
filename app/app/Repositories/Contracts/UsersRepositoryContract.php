<?php

namespace App\Repositories\Contracts;

interface UsersRepositoryContract
{
    public function all();

    public function findById($userId);

    public function update($userId, array $data);

    public function destroy($userId);

    public function isCommon($userId);
}
