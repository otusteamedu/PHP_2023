<?php

declare(strict_types=1);

namespace Girevik1\WebSerBalancer\Application;

use Exception;
use Girevik1\WebSerBalancer\Helpers\RequestValidationHelper;

class ApplicationMain
{
    private array $newRequest = [];

    public function __construct()
    {
        if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $this->newRequest = $_POST;
        };
    }

    public function execute()
    {
        $responseCode = 200;
        $textResponse = '';

        try {
            $textResponse = RequestValidationHelper::checkBrackets($this->newRequest);
        } catch (Exception $e) {
            $responseCode = 400;
            $textResponse = $e->getMessage();
        }

        http_response_code($responseCode);
        echo $textResponse;
    }
}
