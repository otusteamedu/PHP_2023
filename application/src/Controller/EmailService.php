<?php

namespace Gesparo\Hw\Controller;

use Gesparo\Hw\Email\DomainChecker;
use Gesparo\Hw\Email\EmailChecker;
use Gesparo\Hw\Email\FileParser;
use Gesparo\Hw\Email\Response;
use Gesparo\Hw\Email\Validator;

class EmailService
{
    private string $apiKey;
    private string $fileWithEmails;

    public function __construct(string $apiKey, string $fileWithEmails)
    {
        $this->apiKey = $apiKey;
        $this->fileWithEmails = $fileWithEmails;
    }

    public function make(): void
    {
        $emailChecker = new EmailChecker(new DomainChecker($this->apiKey));
        $fileParser = new FileParser($this->fileWithEmails);
        $validatedEmails = (new Validator($fileParser, $emailChecker))->validate();

        (new Response())->response($validatedEmails);
    }
}
