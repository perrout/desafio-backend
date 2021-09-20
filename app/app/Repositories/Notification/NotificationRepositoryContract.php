<?php

namespace App\Repositories\Notification;

interface NotificationRepositoryContract
{
    public function create(array $data);

    public function setAsSent(int $notificationId);

}
