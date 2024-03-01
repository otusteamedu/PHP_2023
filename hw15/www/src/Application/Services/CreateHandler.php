<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Application\Services;

use Elastic\Elasticsearch\Exception\ElasticsearchException;
use Exception;
use Shabanov\Otusphp\Domain\Query\QueryHandlerInterface;

readonly class CreateHandler
{
    public function __construct() {}

    /**
     * @throws Exception
     */
    public function __invoke(QueryHandlerInterface $queryHandler): void
    {
        try {
            $queryHandler->run();
        } catch (ElasticsearchException $e) {
            throw new Exception('Error create Index: ' . $e->getMessage());
        }
    }
}
