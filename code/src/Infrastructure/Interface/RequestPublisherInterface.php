<?php
declare(strict_types=1);

namespace Art\Code\Infrastructure\Interface;

interface RequestPublisherInterface
{
    public function send(array $data);
}