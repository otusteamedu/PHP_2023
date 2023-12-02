<?php

namespace Dshevchenko\Emailchecker\Controllers;

use Dshevchenko\Emailchecker\Checker;

class ApiController
{
    /**
     * Проверяет список электронных адресов, полученных из входного потока данных на валидность.
     *
     * @return void
     */
    public function checkEmails()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo 'Method Not Allowed. Please use the POST method.';
            return;
        }
        try {
            $checker = new Checker();
            $rawPayload = file_get_contents('php://input');
            if (empty($rawPayload)) {
                throw new \Exception('No payload given.');
            }
            $jsonPayload = json_decode($rawPayload, true);
            $arrResult = [];
            foreach ($jsonPayload['emails'] as $email) {
                $arrResult[$email] = $checker->check($email);
            }
            $returnPayload = json_encode($arrResult);
            echo $returnPayload;
        } catch (\Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }
}
