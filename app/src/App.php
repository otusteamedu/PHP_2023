<?php

declare(strict_types=1);

namespace Yevgen87\App;

use Exception;
use Yevgen87\App\Services\ValidBrackets;

class App
{
    public function run()
    {
        $string = $_POST['string'] ?? null;

        try {
            $isValidBrackets = new ValidBrackets($string);
            $status = $isValidBrackets->check();
            echo $status;
        } catch (Exception $e) {
            http_response_code(400);
            exit($e->getMessage());
        }
        http_response_code(200);
    }
}
