<?php

namespace Root\Www\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Root\Www\Domain\Service\CheckEmailService;

final class HomeAction
{
    private $checkEmail;

    public function __construct(CheckEmailService $checkEmail)
    {
        $this->checkEmail = $checkEmail;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data = $request->getMethod() === 'GET' ? (array)$request->getQueryParams() : (array)$request->getParsedBody();

        $res = $this->checkEmail->run($data);
        $response->getBody()->write($res);

        return $response;
    }
}
