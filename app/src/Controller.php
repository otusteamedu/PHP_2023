<?php

namespace Yakovgulyuta\Hw5;

class Controller
{
    private Request $request;
    private EmailValidator $validator;

    public function __construct()
    {
        $this->request = new Request();
        $this->validator = new EmailValidator();
    }

    public function validateEmails(): void
    {
        $post = $this->request->getPost();
        $validate = $this->validator->validate($post['emails'] ?? '');
        http_response_code($validate['code']);
        echo $validate['message'];
    }

}
