<?php

declare(strict_types=1);

namespace App\Application\Decorator\Content;

final class ShareLinkContentDecorator extends ContentDecorator
{
    public function getValue(): string
    {
        return parent::getValue() . PHP_EOL . 'Поделиться: {shareVk} {shareOk}';
    }
}
