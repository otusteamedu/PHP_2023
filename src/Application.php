<?php

namespace WorkingCode\Hw4;

use WorkingCode\Hw4\Exception\ValidatorException;
use WorkingCode\Hw4\Handler\ResponseHandler;
use WorkingCode\Hw4\Http\Response;
use WorkingCode\Hw4\Validator\NotEmptyValidator;
use WorkingCode\Hw4\Validator\PairedBracketsValidator;

class Application
{
    public function run(): void
    {
        $message  = $_POST['string'] ?? '';
        $response = new Response();

        try {
            $notEmptyValidator = new NotEmptyValidator();

            if (!$notEmptyValidator->validate($message)) {
                throw new ValidatorException('Сообщение не должно быть пустым');
            }

            $pairedBracketsValidator = new PairedBracketsValidator();

            if (!$pairedBracketsValidator->validate($message)) {
                throw new ValidatorException('В сообщение не корректно кол-во открытых и закрытых скобок');
            }

            $response->setStatusCode(Response::HTTP_OK)
                ->setMessage('Сообщение корректно');
        } catch (ValidatorException $e) {
            $response->setMessage($e->getMessage())
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $responseHandler = new ResponseHandler();
        $responseHandler->send($response);
    }
}
