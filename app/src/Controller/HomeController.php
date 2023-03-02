<?php

declare(strict_types=1);

namespace Imitronov\Hw4\Controller;

use Imitronov\Hw4\Components\DockerContainer;
use Imitronov\Hw4\Components\Session;
use Imitronov\Hw4\Enum\BracketsStringValidationCounter;
use Imitronov\Hw4\Http\Input\HttpBracketsStringValidationInput;
use Imitronov\Hw4\Http\Response;
use Imitronov\Hw4\UseCase\BracketsString\BracketsStringValidation;
use Imitronov\Hw4\View\HtmlView;

final class HomeController
{
    public function index(
        DockerContainer $dockerContainer,
        Session $session,
    ): Response {
        return new Response(new HtmlView(
            'index',
            'Валидатор скобок в строке.',
            [
                'container' => $dockerContainer->getId(),
                'successfulCount' => (int) $session->get(BracketsStringValidationCounter::SUCCESSFUL->value) ?? 0,
                'failedCount' => (int) $session->get(BracketsStringValidationCounter::FAILED->value) ?? 0,
            ]
        ));
    }

    public function validation(
        DockerContainer $dockerContainer,
        HttpBracketsStringValidationInput $input,
        BracketsStringValidation $bracketsStringValidation,
        Session $session,
    ): Response {
        $result = $bracketsStringValidation->handle($input);

        return new Response(
            new HtmlView(
                'validation',
                'Результат валидации строки.',
                [
                    'container' => $dockerContainer->getId(),
                    'successfulCount' => (int) $session->get(BracketsStringValidationCounter::SUCCESSFUL->value),
                    'failedCount' => (int) $session->get(BracketsStringValidationCounter::FAILED->value),
                    'string' => $result->string,
                    'isValid' => $result->isValid,
                    'message' => $result->message,
                ],
            ),
            $result->isValid ? 200 : 400,
        );
    }
}
