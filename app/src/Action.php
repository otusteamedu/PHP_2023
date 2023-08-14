<?php

declare(strict_types=1);

namespace Root\App;

use Exception;
use JsonSerializable;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Action
{
    protected ContainerInterface $container;
    protected ServerRequestInterface $request;
    protected ResponseInterface $response;
    protected array $args = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->action();
        } catch (NotFoundException $e) {
            return $this->responsePrepare(['message' => $e->getMessage()], 404);
        } catch (AppException|BadRequestException $e) {
            return $this->responsePrepare(['message' => $e->getMessage()], 400);
        } catch (Exception $e) {
            //throw new HttpInternalServerErrorException($this->request, $e->getMessage());
            return $this->responsePrepare(['message' => $e->getMessage()], 500);
        }
    }

    abstract protected function action(): ResponseInterface;

    protected function responsePrepare(array|null|JsonSerializable $data, int $code = 200): ResponseInterface
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $this->response->getBody()->write($json);
        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);

    }
}
