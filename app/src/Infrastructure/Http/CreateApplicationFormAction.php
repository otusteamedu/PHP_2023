<?php

namespace App\Infrastructure\Http;

use App\Application\UseCase\CreateApplicationForm;
use App\Application\UseCase\Request\CreateApplicationFormRequest;
use App\Exception\PublishException;
use App\Infrastructure\Queues\Publisher\PublisherInterface;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateApplicationFormAction
{
    private PublisherInterface $publisher;
    private CreateApplicationForm $useCase;

    public function __construct(
        PublisherInterface $publisher,
        CreateApplicationForm $useCase
    ) {
        $this->publisher = $publisher;
        $this->useCase = $useCase;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        try {
            $data = $request->getParsedBody();
            $requestDto = new CreateApplicationFormRequest($data['email'], $data['message']);
            $responseDto = ($this->useCase)($requestDto);
            $data['id'] = $responseDto->id;

            $this->publisher->publish(json_encode($data));

            $body = [
                "id" => $responseDto->id,
                "email" => $data['email'],
                "message" => $data['message'],
                "status" => $responseDto->status
            ];
            $code = 201;
        } catch (PublishException $e) {
            $body = ["message" => $e->getMessage()];
            $code = 500;
        } catch (Exception $e) {
            $body = ["message" => $e->getMessage()];
            $code = 400;
        }

        $response->getBody()->write(json_encode($body));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}
