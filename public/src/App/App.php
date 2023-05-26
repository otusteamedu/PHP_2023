<?php

namespace YuzyukRoman\App;

use YuzyukRoman\Http\Response;
use YuzyukRoman\Http\Request;

class App
{
    private string $field;
    private string $successMessage;
    private string $errorMessage;

    public function __construct(string $field, string $successMessage, string $errorMessage)
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
        $counter = 0;
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] === '(') {
                $counter++;
            }
            if ($string[$i] === ')') {
                if (!boolval($counter)) {
                    return false;
                }
                $counter--;
            }
        }

        return !boolval($counter);
    }

    private function isStringEmpty(string $string): bool
    {
        return !strlen($string);
    }
}
