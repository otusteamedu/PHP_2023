<?php

namespace src\application;

use Exception;

class AppDesignPatternsAPI
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        try {
            AppWrapper::container();

            AppWrapper::build()
                ->middlewares()
                ->routes()
                ->run();
        } catch (Exception $exception) {
            echo AppWrapper::build()
                ->failResponse(
                    $exception->getCode(),
                    [
                        'error' => [
                            'code' => $exception->getCode(),
                            'message' => $exception->getMessage(),
                        ],
                    ]
                )
                ->getBody();
        }
    }
}
