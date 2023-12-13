<?php

namespace App\Infrastructure\Http;

use App\Domain\Entity\ApplicationForm;
use App\Domain\Repository\ApplicationFormInterface;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetApplicationFormAction
{
    private ApplicationFormInterface $repository;

    public function __construct(ApplicationFormInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        if (isset($args['id'])) {
            $id = $args['id'];
            $applicationForm = $this->repository->findOneById($id);

            if (is_null($applicationForm)) {
                $code = 404;
                $body = ["message" => "The resource does not exist"];
            } else {
                $body = $applicationForm->toArray();
                $code = 200;
            }
        } else {
            $applicationFormCollection = $this->repository->findAll();
            $applicationFormCollection = $applicationFormCollection->map(function ($item) {
                return $item->toArray();
            });
            $body = $applicationFormCollection->toArray();
            $code = 200;
        }

        $response->getBody()->write(json_encode($body));

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}
