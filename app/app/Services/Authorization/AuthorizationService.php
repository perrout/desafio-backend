<?php

namespace App\Services\Authorization;

use Exception;
use Illuminate\Support\Facades\Http;

class AuthorizationService implements AuthorizationServiceContract
{
    private $httpClient;
    private $endpoint;

    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->endpoint = env('AUTHORIZATION_ENDPOINT', 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
    }

    public function status()
    {
        try {
            $response = $this->httpClient::get($this->endpoint);
            if ($response->ok() && $response->json('message') === 'Autorizado') {
                return true;
            }
            return false;
        } catch(Exception $e) {
            return false;
        }
    }
}
