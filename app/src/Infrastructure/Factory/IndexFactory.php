<?php

namespace App\Infrastructure\Factory;

use Ehann\RediSearch\AbstractIndex;
use Ehann\RediSearch\Exceptions\NoFieldsInIndexException;
use Ehann\RediSearch\Index;
use Ehann\RedisRaw\AbstractRedisRawClient;

class IndexFactory
{
    private const PRIORITY_FIELD_NAME = 'priority';
    private const EVENT_FIELD_NAME = 'name';
    private const PARAM_FIELD_NAME = 'param';

    /**
     * @throws NoFieldsInIndexException
     */
    public static function create(AbstractRedisRawClient $client): AbstractIndex
    {
        $index = new Index($client);

        $index->addNumericField(self::PRIORITY_FIELD_NAME)
            ->addTextField(self::EVENT_FIELD_NAME);

        for ($i = 1; $i < 5; $i++) {
            $index->addNumericField(self::PARAM_FIELD_NAME . $i);
        }

        //$index->drop(); die;

        $index->create();

        return $index;
    }
}
