<?php

namespace Nalofree\Hw5;

class Request
{
    private array $get;
    private array $post;
    private array $server;

    public function __construct($get, $post, $server)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
    }

    public function getQueryParam($name)
    {
        return isset($this->get[$name]) ? $this->get[$name] : null;
    }

    public function getPostParam($name)
    {
        return isset($this->post[$name]) ? $this->post[$name] : null;
    }

    public function getMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }
}
