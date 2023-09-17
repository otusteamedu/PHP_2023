<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Controller;

use Art\Code\Infrastructure\Rabbit\RabbitMQConnector;
use Art\Code\Infrastructure\Services\Queue\StatementPublisher\StatementPublisher;
use Art\Code\Infrastructure\View\View;
use JsonException;

class StatementController
{
    public  function index(): void
    {
        View::render('statementForm', [
            'title' => 'Main page',
        ]);
    }

    /**
     * @throws JsonException
     */
    public function get(): void
    {
        $cn = new RabbitMQConnector();
        $publisher = new StatementPublisher($cn);
        $publisher->send($_REQUEST);

        View::render('statementRequestSend', [
            'title' => 'Request sender confirmed.',
        ]);
    }
}