<?php

namespace App\Services\Authorization;

use Exception;
use Illuminate\Support\Facades\Http;

class AuthorizationService implements AuthorizationServiceContract
{
    private $httpClient;

    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function status()
    {
        try {
            $url = env('AUTHORIZATION_URL', 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            $response = $this->httpClient::get($url);
            if ($response->ok() && $response->json('message') === 'Autorizado') {
                return true;
            }
            return false;
        } catch(Exception $e) {
            return false;
        }
    }
}
