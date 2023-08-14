<?php

declare(strict_types=1);

namespace Root\App;

use DateTime;
use Exception;
use PDO;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Container\ContainerInterface;
use Root\App\Data\TaskDto;
use Root\App\Data\TaskStatus;
use Throwable;

class Worker
{
    private string $tag;
    private ContainerInterface $container;
    private TaskTable $taskTable;
    private Query $query;

    /**
     * @throws AppException
     */
    public function __construct(string $tag, ContainerInterface $container)
    {
        $this->tag = $tag;
        $this->container = $container;

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
     * @throws AppException
     */
    public function run(): void
    {
        $this->query->listen($this->tag, [$this, 'exec']);
    }

    public function exec(AMQPMessage $message): void
    {
        try {
            $body = json_decode($message->getBody(), true);
            if (!is_array($body) || empty($body)) {
                throw new AppException('Error parse message');
            }

            $task = (new TaskDto())
                ->setId($body['id'] ?? null)
                ->setAddTimestamp($body['add_timestamp'] ?? null)
                ->setBody($body['body'] ?? null)
                ->setExecTimestamp($body['exec_timestamp'] ?? null)
                ->setFinishTimestamp($body['finish_timestamp'] ?? null)
                ->setStatus($body['status'] ?? null);

            if (empty($task->id)) {
                throw new AppException('Error empty task id');
            }

            $this->execStart($task);
            sleep(rand(10, 20));
            $this->execFinished($task);

            $message->ack();

        } catch (AppException|NotFoundException $e) {
            $message->nack();
            echo 'Error exec. ' . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * @throws AppException
     * @throws NotFoundException
     */
    private function execStart(TaskDto $task): void
    {
        $updateTask = (new TaskDto())
            ->setId($task->id)
            ->setExecTimestamp(new DateTime())
            ->setStatus(TaskStatus::Processing);
        $this->taskTable->update($updateTask);

    }

    /**
     * @throws AppException
     * @throws NotFoundException
     */
    private function execFinished(TaskDto $task): void
    {
        $updateTask = (new TaskDto())
            ->setId($task->id)
            ->setFinishTimestamp(new DateTime())
            ->setStatus(TaskStatus::Finished);
        $this->taskTable->update($updateTask);
    }

}