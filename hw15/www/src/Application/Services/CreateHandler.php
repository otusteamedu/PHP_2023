<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Application\Services;

use Elastic\Elasticsearch\Exception\ElasticsearchException;
use Exception;
use Shabanov\Otusphp\Application\Dto\CreateHandlerRequest;

readonly class CreateHandler
{
    public function __construct(private CreateHandlerRequest $request) {}

    /**
     * @throws Exception
     */
    public function __invoke(): void
    {
        try {
            $this->request->createRepository->run();
        } catch (ElasticsearchException $e) {
            throw new Exception('Error create Index: ' . $e->getMessage());
        }
    }
}
