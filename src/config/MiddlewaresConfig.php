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
                $configStorage = $this->get(ParameterNames::ConfigStorage)
                    ->fromDotEnvFile([dirname(__DIR__), '.env']);

                $userId = $configStorage->get('USER');

                $request = $request->withAttribute(
                    ParameterNames::UserAttribute,
                    $userId
                );
                return $handler->handle($request);
            },

            'notifyService' => function (Request $request, $handler) {
                return $handler->handle(
                    $request->withAttribute(
                        ParameterNames::NotifyServiceAttribute,
                        $this->get(ParameterNames::NotifyService)
                    )
                );
            },

            'repository' => function (Request $request, $handler) {
                return $handler->handle(
                    $request->withAttribute(
                        ParameterNames::RepositoryAttribute,
                        $this->get(ParameterNames::Repository)
                    )
                );
            }
        ];
    }
}
