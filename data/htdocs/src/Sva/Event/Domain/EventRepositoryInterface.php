<?php

namespace Sva\Event\Domain;

interface EventRepositoryInterface
{
    /**
     * @param array $arParams
     * @return array
     */
    public function getList(array $arParams = []): array;

    /**
     * @param Event $event
     * @return bool
     */
    public function add(Event $event): bool;

    /**
     * @return bool
     */
    public function clear(): bool;
}
