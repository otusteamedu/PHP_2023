<?php

declare(strict_types=1);

namespace Art\Php2023\Infrastructure\Http;

use Art\Code\Infrastructure\Proxy\PropertyProxy;
use Art\Php2023\Infrastructure\Contact\PropertyInterface;
use Art\Php2023\Infrastructure\Exception\UriNotFoundException;

final class AppController
{
    private ?array $getData = [];
//- создать новый объект недвижимости
//- загрузить список объектов
//- загрузить конкретный объект
//- сформировать пакет документов для аренды


    public function __construct()
    {
        $this->getData = json_decode(file_get_contents('php://input'), true);
    }

    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     * @throws UriNotFoundException
     */
    private function getController(string $uri): PropertyInterface
    {
        return match ($uri) {
            'create-new-property' => new PropertyProxy(),
//            'search' => new SearchBookCommand($this->dependence[RepositoryInterface::class], $this->argv),
            default => throw new UriNotFoundException("Such a uri - \"$uri\" not found")
        };
    }

    /**
     * @throws UriNotFoundException
     */
    public function run(): void
    {
        $selectedController = $this->getController($this->getURI());
        $selectedController->execute($this->getData);
    }
}