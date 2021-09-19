<?php

namespace App\Services\Users;

interface UsersServiceContract
{
    public function all();

    public function show($userId);

    public function update($userId, array $data);

    public function destroy($userId);

    public function isCommon($userId);

    public function getWallet($userId);
}
