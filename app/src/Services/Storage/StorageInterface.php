<?php

declare(strict_types=1);

namespace Yevgen87\App\Services\Storage;

interface StorageInterface
{

    /**
     * @param integer $priority
     * @param array $condition
     * @param string $event
     * @return void
     */
    public function store(int $priority, array $conditions, string $event);

    public function deleteAll();

    /**
     * @param string $key
     * @return void
     */
    public function delete(string $key);

    public function getRelevant(array $conditions);

}