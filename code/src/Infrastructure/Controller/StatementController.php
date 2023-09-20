<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Controller;

use Art\Code\Infrastructure\Interface\ConnectorInterface;
use Art\Code\Infrastructure\Interface\StatementPublisherInterface;
use Art\Code\Infrastructure\Rabbit\RabbitMQConnector;
use Art\Code\Infrastructure\Services\Queue\StatementPublisher\StatementPublisher;
use Art\Code\Infrastructure\View\View;
use JsonException;

class StatementController
{
    private readonly ConnectorInterface $queueConnector;
    private readonly StatementPublisherInterface $publisher;

    public function __construct() {
        $this->queueConnector = new RabbitMQConnector();
        $this->publisher = new StatementPublisher($this->queueConnector);

    }

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
        $this->publisher->send($_REQUEST);

        View::render('statementRequestSend', [
            'title' => 'Request sender confirmed.',
        ]);
    }
}