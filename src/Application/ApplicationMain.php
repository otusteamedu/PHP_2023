<?php

declare(strict_types=1);

namespace Art\Php2023\Application;

use Exception;
use Art\Php2023\Helpers\MailValidationHelper;
use Art\Php2023\Helpers\ResponseFormation;

class ApplicationMain
{
    public function execute()
    {
        try {
            return ResponseFormation::makeResponse(MailValidationHelper::checkEmailList(), 204);
        } catch (Exception $e) {
            return ResponseFormation::makeResponse($e->getMessage(), 400);
        }
    }
}
