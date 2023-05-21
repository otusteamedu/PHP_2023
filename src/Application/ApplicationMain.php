<?php

declare(strict_types=1);

namespace Girevik1\WebSerBalancer\Application;

use Exception;
use Girevik1\WebSerBalancer\Helpers\RequestValidationHelper;
use Girevik1\WebSerBalancer\Helpers\ResponseFormation;

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
        try {
            return ResponseFormation::makeResponse(RequestValidationHelper::checkBrackets($this->newRequest), 204);
        } catch (Exception $e) {
            return ResponseFormation::makeResponse($e->getMessage(), 400);
        }
    }
}
