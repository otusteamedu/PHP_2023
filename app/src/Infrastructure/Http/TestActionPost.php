<?php

namespace App\Infrastructure\Http;

use App\Infrastructure\Queues\PublisherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestActionPost
{
    private PublisherInterface $publisher;

    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data = $request->getParsedBody();

        try {
            $this->publisher->publish(json_encode($data));
            $message = "success";
            $code = 200;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $code = 500;
        }

        $response->getBody()->write(json_encode(["message" => $message]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}
