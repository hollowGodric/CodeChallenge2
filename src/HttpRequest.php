<?php

namespace App;


class HttpRequest
{
    private $get;
    private $post;
    private $server;

    /**
     * HttpRequest constructor.
     */
    public function __construct()
    {
        $this->get    = $_GET;
        $this->post   = $_POST;
        $this->server = $_SERVER;

        $_GET = $_POST = [];
    }

    /**
     * @param int|string $key
     * @param mixed      $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->get[$key] ?? $this->post[$key] ?? $default;
    }

    public function getHeaders()
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers[substr($key, 5)] = $value;
            }
        }

        return $headers;
    }

    public function getPath()
    {
        return $this->server['PATH_INFO'] ?? '/';
    }

    public function getMethod() : string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }
}