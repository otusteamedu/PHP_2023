<?php

declare(strict_types=1);

namespace Yalanskiy\HomeworkRedis;

/**
 * AnalyticInterface
 */
interface AnalyticInterface
{
    /**
     * Clear all data in DB
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Add one data record to DB
     *
     * @param string $event
     * @param int $score
     * @param array $params
     *
     * @return void
     */
    public function add(string $event, int $score, array $params): void;

    /**
     * Search record with max score and according to params.
     *
     * @param array $params
     *
     * @return array
     */
    public function search(array $params): array;
}
