<?php

namespace src\application\api;

use Psr\Http\Message\ResponseInterface as Response;

class JsonResponse
{
    private Response $response;

    public static function use(Response $response, array $dataOverride = []): self
    {
        $json = new self();

        $response->withHeader('Content-type', 'application/json');

        $data = empty($dataOverride) ? ['success' => true] : $dataOverride;
        $payload = json_encode($data);
        $response->getBody()->write($payload);

        $json->setResponse($response);

        return $json;
    }

    public function success(): self
    {
        $this->getResponse()->withStatus(200);
        return $this;
    }

    public function error(): self
    {
        $this->getResponse()->withStatus(500);
        return $this;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

    public function withBody(array $data): self
    {
        $payload = json_encode($data);
        $this->getResponse()->getBody()->write($payload);
        return $this;
    }
}
