<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage;

class Name
{
    private string $name;

    public function __construct(string $name)
    {
        $this->assertValidEvent($name);
        $this->name = $name;
    }

    private function assertValidEvent(string $name): void
    {
        if (empty($name)) {
            throw new \Exception("Имя не может быть пустой строкой.");
        }
    }

    public function getValue(): string
    {
        return $this->name;
    }
}