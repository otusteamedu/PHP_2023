<?php

namespace App\Service;

interface BookInterface
{
    public function getTitle(): string;

    public function getSku(): string;

    public function getCategory(): string;

    public function getPrice(): int;

    public function getStock(): array;
}