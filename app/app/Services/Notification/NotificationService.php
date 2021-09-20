<?php

namespace App\Services\Notification;

use Exception;
use Illuminate\Support\Facades\Http;

class NotificationService implements NotificationServiceContract
{
    private $httpClient;
    private $endpoint;

    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->endpoint = env('AUTHORIZATION_ENDPOINT', 'http://o4d9z.mocklab.io/notify');
    }

    public function status()
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
}
