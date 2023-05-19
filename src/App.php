<?php

declare(strict_types=1);

namespace Iosh\Mysite;

use Exception;
use Throwable;

class App
{
    private string $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    public function run(): string
    {
        try {
            $result = $this->handleRequest();
            $this->setSuccess(true);
            return $result;
        } catch (Throwable $e) {
            $this->setSuccess(false);
            return $e->getMessage();
        }
    }

    /**
     * @throws Exception
     */
    public function handleRequest(): string
    {
        return BracketsChecker::check($this->requestData);
    }

    private function setSuccess(bool $success)
    {
        http_response_code($success ? 200 : 418);
    }
}
