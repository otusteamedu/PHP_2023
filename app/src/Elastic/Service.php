<?php

declare(strict_types=1);

namespace Desaulenko\Hw11\Elastic;

class Service
{
    protected Controller $controller;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function searchByTitleAndPrice(string $q, int $priceFrom): void
    {
        $body = ['body' => Helper::makeBodySearch($q, $priceFrom)];
        Helper::printResult($this->controller->search($body));
    }
}
