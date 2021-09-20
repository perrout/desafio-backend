<?php

namespace App\Services\Notification;

interface NotificationServiceContract
{
    public function send(array $notification);

    public function handleNotitication(array $notification);
}
