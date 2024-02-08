<?php
declare(strict_types=1);

namespace WorkingCode\Hw11\Command;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use JsonException;
use WorkingCode\Hw11\Service\ElasticsearchService;

class CreateIndexWithData implements Command
{
    public const OPTIONS = ['create_index_with_data'];

    private const INDEX_NAME           = 'otus-shop';
    private const SCHEMA_INDEX_PATH    = './data/index_otus_shop.json';
    private const DATA_FOR_IMPORT_PATH = './data/books.json';

    public function __construct(
        private readonly ElasticsearchService $ESService
    ) {
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws JsonException
     * @throws MissingParameterException
     */
    public function execute(): int
    {
        $indexParams = json_decode(file_get_contents(static::SCHEMA_INDEX_PATH), true, flags: JSON_THROW_ON_ERROR);

        if (
            $this->ESService->createIndex(static::INDEX_NAME, $indexParams)
            && $this->ESService->importFromFile(static::DATA_FOR_IMPORT_PATH, static::INDEX_NAME)
        ) {
            return static::SUCCESS;
        } else {
            return static::FAILURE;
        }
    }
}
