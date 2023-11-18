<?php

namespace src\config;

use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @method get(string $ConfigStorage)
 */
class MiddlewaresConfig
{
    public static function describes(): array
    {
        return [
            'authUserId' => function (Request $request, $handler) {
                $configStorage = $this->get(ParameterNames::CONFIG_STORAGE)
                    ->fromDotEnvFile([dirname(__DIR__), '.env']);

                $userId = $configStorage->get('USER');

                $request = $request->withAttribute(
                    ParameterNames::USER_ATTRIBUTE,
                    $userId
                );
                return $handler->handle($request);
            },

            'notifyService' => function (Request $request, $handler) {
                return $handler->handle(
                    $request->withAttribute(
                        ParameterNames::NOTIFY_SERVICE_ATTRIBUTE,
                        $this->get(ParameterNames::NOTIFY_SERVICE)
                    )
                );
            },

            'repository' => function (Request $request, $handler) {
                return $handler->handle(
                    $request->withAttribute(
                        ParameterNames::REPOSITORY_ATTRIBUTE,
                        $this->get(ParameterNames::REPOSITORY)
                    )
                );
            }
        ];
    }
}
