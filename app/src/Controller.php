<?php

namespace Yakovgulyuta\Hw5;

use PHP_CodeSniffer\Reporter;

class Controller
{
    private Response $response;
    private EmailValidator $validator;

    public function __construct()
    {
        $this->response = new Response();
        $this->validator = new EmailValidator();
    }

    public function validateEmails(): void
    {
        $post = $_POST;
        $validate = $this->validator->validate($post['emails'] ?? '');

        $this->response->sendResponse($validate['code'], $validate['message']);
    }
}
