<?php

declare(strict_types=1);

namespace Timerkhanov\Elastic\Command;

use Timerkhanov\Elastic\Command\AbstractCommand;
use Timerkhanov\Elastic\Exception\FileNotFoundException;
use Timerkhanov\Elastic\Exception\RepositoryException;
use Timerkhanov\Elastic\Repository\ElasticSearchRepository;
use Timerkhanov\Elastic\Repository\Interface\RepositoryInterface;

class LoadBookCommand extends AbstractCommand
{
    public function __construct(
        private readonly ElasticSearchRepository $repository,
        array $args
    ) {
        parent::__construct($args);
    }

    public function execute(): void
    {
        try {
            $this->repository->load($this->args['path'] ?? '');

            $response = 'Books has been loaded';
        } catch (FileNotFoundException | RepositoryException $exception) {
            $response = $exception->getMessage();
        }

        echo $response . PHP_EOL;
    }
}
