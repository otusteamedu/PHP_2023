<?php

namespace src\config;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @method get(string $EventController)
 */
class RoutesConfig
{
    public static function describes(): array
    {
        return [
            'post' => [
                [
                    'pattern' => '/api/emit/{event}',
                    'callable' =>
                        function (Request $request, Response $response): Response {
                            return ($this->get(ParameterNames::EVENT_CONTROLLER))
                                ->add($request, $response);
                        }
                ],

                [
                    'pattern' => '/api/event/{event}/subscriber/{subscriber}',
                    'callable' =>
                        function (Request $request, Response $response): Response {
                            return ($this->get(ParameterNames::EVENT_CONTROLLER))
                                ->addSubscriberByEvent($request, $response);
                        }
                ]
            ]
        ];
    }
}
