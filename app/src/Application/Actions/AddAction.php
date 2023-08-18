<?php

declare(strict_types=1);

namespace Root\App\Application\Actions;

use Exception;
use PDO;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Root\App\Application\Action;
use Root\App\Application\QueryInterface;
use Root\App\Application\SettingsInterface;
use Root\App\Application\TaskRepositoryInterface;
use Root\App\Domain\DTO\TaskDto;
use Root\App\Domain\Exception\AppException;
use Root\App\Domain\Exception\BadRequestException;
use Root\App\Infrastructure\Database\TaskTableDatabaseRepository;
use Root\App\Infrastructure\Query\AmqpQuery;
use Throwable;

class AddAction extends Action
{
    private TaskRepositoryInterface $taskTable;
    private QueryInterface $query;

    /**
     * @throws AppException
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        try {
            $this->taskTable = new TaskTableDatabaseRepository($this->container->get(PDO::class));
        } catch (Exception | Throwable $e) {
            throw new AppException('Error connect database. ' . $e->getMessage());
        }

        try {
            $this->query = new AmqpQuery(
                $this->container->get(AMQPStreamConnection::class),
                ($this->container->get(SettingsInterface::class)->get('rabbitmq'))['queryName']
            );
        } catch (Exception | Throwable $e) {
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
