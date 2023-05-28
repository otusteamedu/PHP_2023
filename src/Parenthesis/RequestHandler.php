<?php

declare(strict_types=1);

namespace Otus\App\Parenthesis;

use Otus\App\Http\Request;
use Otus\App\Http\RequestHandlerInterface;
use Otus\App\Http\Response;
use Otus\App\Validator\ValidatorInterface;

final readonly class RequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private ValidatorInterface $stringValidator,
    ) {
    }

    public function handle(Request $request): Response
    {
        return $this->stringValidator->validate($_POST['string'])
            ? new Response(200, 'You are good!')
            : new Response(400, 'Incorrect string');
    }
}
