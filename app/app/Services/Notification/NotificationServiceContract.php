<?php

namespace App\Services\Notification;

interface NotificationServiceContract
{
    public function send(array $notification);

    public function createNotitication(array $notification);

    public function handleNotitication(int $notificationId);
}
