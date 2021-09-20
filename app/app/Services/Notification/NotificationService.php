<?php

namespace App\Services\Notification;

use App\Repositories\Notification\NotificationRepositoryContract;
use Exception;
use Illuminate\Support\Facades\Http;

class NotificationService implements NotificationServiceContract
{
    private $endpoint;
    private $httpClient;
    private $notificationRepository;

    public function __construct(Http $httpClient, NotificationRepositoryContract $notificationRepository)
    {
        $this->endpoint = env('AUTHORIZATION_ENDPOINT', 'http://o4d9z.mocklab.io/notify');
        $this->httpClient = $httpClient;
        $this->notificationRepository = $notificationRepository;
    }

    public function send(array $notification)
    {
        try {
            $response = $this->httpClient::get($this->endpoint);
            if ($response->ok() && $response->json('message') === 'Success') {
                return true;
            }
            return false;
        } catch(Exception $e) {
            return false;
        }
    }

    public function handleNotitication(array $notification)
    {
        return $this->notificationRepository->setAsSent($notification);
    }
}
