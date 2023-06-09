<?php
declare(strict_types=1);

namespace Nautilus\Validator;

use Exception;

class Request
{
    private array $request;
    public function __construct(array $request)
    {
        if(!$this->checkRequest($request)) {
            throw new \Exception("Пустой запрос");
        }
        $this->request = $request;
    }


    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * @param array $request
     */
    private function checkRequest(array $request): bool
    {
        if(empty($request) && count($request) == 0) {
            return false;
        }
        return true;
    }

}