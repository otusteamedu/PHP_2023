<?php

declare(strict_types=1);

namespace Root\App\Application\Actions;

use Exception;
use PDO;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Root\App\Application\Action;
use Root\App\Application\TaskRepositoryInterface;
use Root\App\Domain\Exception\AppException;
use Root\App\Infrastructure\Database\TaskTableDatabaseRepository;
use Throwable;

class ListAction extends Action
{
    private TaskRepositoryInterface $taskTable;

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
    }

    /**
     */
    protected function action(): ResponseInterface
    {
        $tasks = $this->taskTable->findAll();
        return $this->responsePrepare($tasks);
    }

}
