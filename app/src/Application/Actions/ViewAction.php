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
use Root\App\Domain\Exception\BadRequestException;
use Root\App\Domain\Exception\NotFoundException;
use Root\App\Infrastructure\Database\TaskTableDatabaseRepository;
use Throwable;

class ViewAction extends Action
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
     * @throws AppException
     * @throws NotFoundException
     * @throws BadRequestException
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
