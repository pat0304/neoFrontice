<?php

namespace App\Services;

class AIService
{
    private $client;
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }
}
