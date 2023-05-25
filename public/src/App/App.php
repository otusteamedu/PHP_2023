<?php

namespace YuzyukRoman\App;

use YuzyukRoman\Http\Response;
use YuzyukRoman\Http\Request;

class App
{
    private string $field;
    private string $successMessage;
    private string $errorMessage;

    private function __construct(string $field, string $successMessage, string $errorMessage)
    {
        $this->field = $field;
        $this->successMessage = $successMessage;
        $this->errorMessage = $errorMessage;
    }

    public function start(): void
    {
        if (!Request::isPost()) {
            Response::sendNotAllowed();
            return;
        }

        $post = Request::getPost();

        if (!$this->isFieldExist($post) || $this->isStringEmpty($post[$this->field])) {
            Response::sendResponse(400, $this->errorMessage);
            return;
        }

        if (!$this->isValid($post[$this->field])) {
            Response::sendResponse(400, $this->errorMessage);
            return;
        }

        Response::sendResponse(200, $this->successMessage);
    }

    private function isFieldExist(array $request): bool
    {
        return array_key_exists($this->field, $request);
    }

    private function isValid(string $string): bool
    {
        $open = [];
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] === '(') {
                $open[] = $i;
            }
            if ($string[$i] === ')') {
                if (empty($open)) {
                    return false;
                }
                array_pop($open);
            }
        }

        return empty($open);
    }

    private function isStringEmpty(string $string): bool
    {
        return !strlen($string);
    }
}
