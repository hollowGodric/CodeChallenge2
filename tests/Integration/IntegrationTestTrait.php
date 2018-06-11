<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\StreamHandler;
use GuzzleHttp\HandlerStack;

trait IntegrationTestTrait
{
    private $host = 'http://localhost:8000';

    protected function getClient()
    {
        $handler = new StreamHandler();
        $stack   = HandlerStack::create($handler);

        return new Client(['handler' => $stack, 'base_uri' => $this->host]);
    }
}