<?php

namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Repositories\Notification\NotificationRepositoryContract;

class NotificationRepository implements NotificationRepositoryContract
{
    private $model;

    public function __construct()
    {
        $this->model = new Notification;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function setAsSent($notificationId)
    {
        $transaction = $this->model->findOrFail($notificationId);
        $transaction->update(['status' => 1]);
        return $transaction;
    }
}
