<?php

declare(strict_types=1);

namespace App\Statement;

use App\RabbitMQ\Messenger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final readonly class GenerateStatementController
{
    public function __construct(
        private Messenger $messenger,
    ) {
    }

    #[Route('/statement/generate')]
    public function generateStatement(Request $request): Response
    {
        $body = $request->getContent();
        $this->messenger->publish($body);

        return new Response(
            'You have successfully requested a bank statement. As soon as the statement is ready, we will notify you.'
        );
    }
}
