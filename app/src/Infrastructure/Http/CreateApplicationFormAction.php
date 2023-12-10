<?php

namespace App\Infrastructure\Http;

use App\Application\UseCase\CreateApplicationForm;
use App\Application\UseCase\Request\CreateApplicationFormRequest;
use App\Exception\PublishException;
use App\Infrastructure\Notification\EmailNotificationInterface;
use App\Infrastructure\Queues\Publisher\PublisherInterface;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateApplicationFormAction
{
    private PublisherInterface $publisher;
    private CreateApplicationForm $useCase;
    private EmailNotificationInterface $notificator;

    public function __construct(
        PublisherInterface $publisher,
        CreateApplicationForm $useCase,
        EmailNotificationInterface $notificator
    ) {
        $this->publisher = $publisher;
        $this->useCase = $useCase;
        $this->notificator = $notificator;
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
            $this->notificator->send(
                "The application has been accepted for processing. № {$data['id']}",
                'Application Form',
                $data['email']
            );

            $message = "success";
            $code = 201;
        } catch (PublishException $e) {
            $message = $e->getMessage();
            $code = 500;
        } catch (Exception $e) {
            $message = $e->getMessage();
            $code = 400;
        }

        $response->getBody()->write(json_encode(["message" => $message]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}
