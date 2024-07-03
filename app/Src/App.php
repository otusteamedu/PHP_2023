<?php

declare(strict_types=1);

namespace App\Src;

use Exception;

include('Validator.php');
include('Auth.php');

class App
{
    private $validator = null;
    private $auth = null;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->auth = new Auth();
    }

    public function run()
    {
        try {
            $this->auth->auth();
            $string = $_POST['string'] ?? '';
            $result = $this->validator->validate($string);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }

        return [
            'result' => $result,
            'auth' => $this->auth->info()
        ];
    }
}
