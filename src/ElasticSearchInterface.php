<?php

namespace HW11\Elastic;

interface ElasticSearchInterface
{
    public function __construct(string $host, string $user, string $password);
}
