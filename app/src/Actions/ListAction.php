<?php

declare(strict_types=1);

namespace Root\App\Actions;

use Exception;
use PDO;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Root\App\Action;
use Root\App\AppException;
use Root\App\TaskTable;
use Throwable;

class ListAction extends Action
{
    private TaskTable $taskTable;

    /**
     * @throws AppException
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        try {
            $this->taskTable = new TaskTable($this->container->get(PDO::class));
        } catch (Exception | Throwable $e) {
            throw new AppException('Error connect database. ' . $e->getMessage());
        }
    }

    /**
     * @throws AppException
     */
    protected function action(): ResponseInterface
    {
        $tasks = $this->taskTable->findAll();
        return $this->responsePrepare($tasks);
    }
}
