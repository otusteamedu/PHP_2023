<?php

declare(strict_types=1);

namespace Root\App\Actions;

use Exception;
use PDO;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Root\App\Action;
use Root\App\AppException;
use Root\App\BadRequestException;
use Root\App\Data\TaskDto;
use Root\App\Query;
use Root\App\Settings;
use Root\App\TaskTable;
use Throwable;

class AddAction extends Action
{
    private TaskTable $taskTable;
    private Query $query;

    /**
     * @throws AppException
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        try {
            $this->taskTable = new TaskTable($this->container->get(PDO::class));
        } catch (Exception|Throwable $e) {
            throw new AppException('Error connect database. ' . $e->getMessage());
        }

        try {
            $this->query = new Query($this->container->get(AMQPStreamConnection::class),
                ($this->container->get(Settings::class)->get('rabbitmq'))['queryName']);
        } catch (Exception|Throwable $e) {
            throw new AppException('Error connect query. ' . $e->getMessage());
        }
    }

    /**
     * @throws BadRequestException
     * @throws AppException
     */
    protected function action(): ResponseInterface
    {
        $in = $this->request->getParsedBody();
        if (!is_array($in)) {
            throw new BadRequestException('Error input data');
        }

        $task = new TaskDto();
        $task->setBody($in['body'] ?? null);

        $task = $this->taskTable->insert($task);

        $this->query->publish($task);

        return $this->responsePrepare($task);
    }
}