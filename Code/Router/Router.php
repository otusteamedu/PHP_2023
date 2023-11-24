<?php

namespace Code\Router;

class Router
{
    private $method;
    private $post;

    public function __construct($method, $post)
    {
        $this->method = $method;
        $this->post = $post;
    }

    public function route()
    {
        if ($this->method === 'POST') {
            if (isset($this->post['string']) && is_string($this->post['string'])) {
                return $this->post['string'];
            } else {
                http_response_code(400);
                echo 'Bad Request: Missing or invalid "string" parameter.';
                return null;
            }
        } else {
            http_response_code(405);
            echo 'Method Not Allowed: This endpoint only supports POST requests.';
            return null;
        }
    }
}