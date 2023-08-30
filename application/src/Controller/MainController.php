<?php

namespace Gesparo\Hw\Controller;

use Gesparo\Hw\Email\DomainChecker;
use Gesparo\Hw\Email\EmailChecker;
use Gesparo\Hw\Email\FileParser;
use Gesparo\Hw\Email\Response;
use Gesparo\Hw\Email\Validator;
use Gesparo\Hw\PathHelper;

class MainController
{
    public function index(): void
    {
        $emailChecker = new EmailChecker(new DomainChecker($_SERVER['DOMAIN_API']));
        $fileParser = new FileParser(PathHelper::getInstance()->getFilesPath() . 'emails.txt');
        $validatedEmails = (new Validator($fileParser, $emailChecker))->validate();

        (new Response())->response($validatedEmails);
    }
}