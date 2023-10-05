<?php

declare(strict_types=1);

namespace App\Application\Decorator\Content;

final class TimeToReadContentDecorator extends ContentDecorator
{
    public function getValue(): string
    {
        $content = parent::getValue();
        $minutes = mb_strlen($content) / 1000;

        return $content . PHP_EOL . sprintf('Время чтения: %d минут.', $minutes);
    }
}
