<?php

declare(strict_types=1);

namespace Root\App\Actions;

use Exception;
use PDO;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Root\App\Action;
use Root\App\AppException;
use Root\App\BadRequestException;
use Root\App\NotFoundException;
use Root\App\TaskTable;
use Throwable;

class ViewAction extends Action
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
     * @throws BadRequestException
     * @throws NotFoundException
     */
    protected function action(): ResponseInterface
    {
        $id = $this->args['id'] ?? null;
        if (empty($id) || !is_string($id)) {
            throw new BadRequestException('Error empty id');
        }

        $tasks = $this->taskTable->findById($id);
        return $this->responsePrepare($tasks);
    }
}
