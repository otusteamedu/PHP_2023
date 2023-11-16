<?php

namespace src\api;

use DI\Container;
use Exception;
use NdybnovHw03\CnfRead\ConfigStorage;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use src\notify\NotifyService;
use src\repository\Repository;

/**
 * @method get(string $string)
 * @method has(string $string)
 */
class AppDesignPatternsAPI
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        try {
            $container = new Container();
            $container->set('NotifyService', function () {
                return new NotifyService();
            });
            $container->set('Repository', function () {
                return new Repository();
            });
            AppFactory::setContainer($container);

            $app = AppFactory::create();

            $userIdToRequestMiddleware = function (Request $request, $handler) {
                $configStorage = (new ConfigStorage())
                    ->fromDotEnvFile([dirname(__DIR__), '.env']);

                $userId = $configStorage->get('USER');

                $request = $request->withAttribute('user', $userId);
                return $handler->handle($request);
            };
            $app->add($userIdToRequestMiddleware);

            $notifyServiceToRequestMiddleware = function (Request $request, $handler) {
                $notifyService = null;
                if ($this->has('NotifyService')) {
                    $notifyService = $this->get('NotifyService');
                }

                $request = $request->withAttribute('NotifyService', $notifyService);
                return $handler->handle($request);
            };
            $app->add($notifyServiceToRequestMiddleware);

            $repositoryToRequestMiddleware = function (Request $request, $handler) {
                $repository = null;
                if ($this->has('Repository')) {
                    $repository = $this->get('Repository');
                }

                $request = $request->withAttribute('Repository', $repository);
                return $handler->handle($request);
            };
            $app->add($repositoryToRequestMiddleware);

            $app->post(
                '/api/event/add',
                function (Request $request, Response $response): Response {
                    return (new EventController())
                        ->add($request, $response);
                }
            );

            $app->post(
                '/api/event/addSubscriberByEvent',
                function (Request $request, Response $response): Response {
                    return (new EventController())
                        ->addSubscriberByEvent($request, $response);
                }
            );

            $app->run();
        } catch (Exception $exception) {
            throw new $exception($exception->getMessage());
        }
    }
}
