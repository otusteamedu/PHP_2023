<?php

declare(strict_types=1);

namespace Ndybnov\Hw06\commands;

use Ndybnov\Hw06\emails\ExternalDnsMxValidateRule;
use Ndybnov\Hw06\emails\FilterVarValidateRule;
use Ndybnov\Hw06\emails\RegExpValidateRule;
use Ndybnov\Hw06\emails\Validator;
use Ndybnov\Hw06\hw\Output;
use Ndybnov\Hw06\hw\ParameterString;
use NdybnovHw03\CnfRead\ConfigStorage;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CheckEmailsCommand
{
    private string $defaultEmails;

    public function __construct()
    {
        $pathToConfigFile = dirname(__DIR__);
        $configStorage = (new ConfigStorage())
            ->fromDotEnvFile([$pathToConfigFile, 'config.ini']);

        $this->defaultEmails = $configStorage->get('default-emails');
    }

    public function run(Request $request, Response $response): Response
    {
        $strEmails = (new ParameterString())->getValue($request, '');

        if (!strlen($strEmails)) {
            $strEmails = $this->defaultEmails;
        }

        Output::show('Emails: ');
        Output::show(strlen($strEmails) ? $strEmails : '[empty]');

        if (!strlen($strEmails)) {
            return $response->withStatus(200);
        }

        $validator = new Validator();

        $validator->addRule('filter_var', new FilterVarValidateRule());
        $validator->addRule('reg_exp', new RegExpValidateRule());
        $validator->addRule('external_dns_mx', new ExternalDnsMxValidateRule());

        if ($validator->fromString($strEmails)) {
            $errors = $validator->getErrors();
            Output::lineEnd();
            Output::lineEnd();
            Output::show('Message-errors(' . count($errors) . '):');
            Output::lineEnd();
            foreach ($errors as $key => $error) {
                Output::show(' ' . $key . ' :: ' . $error);
                Output::lineEnd();
            }
        }

        return $response->withStatus(200);
    }
}
