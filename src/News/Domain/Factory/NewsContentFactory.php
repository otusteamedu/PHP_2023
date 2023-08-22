<?php

declare(strict_types=1);

namespace App\News\Domain\Factory;

use App\News\Domain\ValueObject\NewsContent;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(id: NewsContentFactoryInterface::class, public: true)]
final readonly class NewsContentFactory implements NewsContentFactoryInterface
{
    public function create(string $text): NewsContent
    {
        return new NewsContent($text);
    }
}
