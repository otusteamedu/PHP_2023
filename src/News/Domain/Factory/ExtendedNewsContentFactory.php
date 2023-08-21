<?php

declare(strict_types=1);

namespace App\News\Domain\Factory;

use App\News\Domain\ValueObject\NewsContent;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;

#[AsDecorator(decorates: NewsContentFactory::class)]
final readonly class ExtendedNewsContentFactory implements NewsContentFactoryInterface
{
    public function __construct(
        #[AutowireDecorated]
        private NewsContentFactoryInterface $decoratedContent,
    ) {
    }

    public function create(string $text): NewsContent
    {
        $originalContent = $this->decoratedContent->create($text)->getContent();
        $readingMinutes = (int) ceil(mb_strlen($originalContent) / 100);
        $readingTime = sprintf('Reading time: %d %s', $readingMinutes, $readingMinutes === 1 ? 'minute' : 'minutes');
        $subscriptionLinks = 'Subscribe to our social media: https://telegram.com/alex';

        return new NewsContent(implode(PHP_EOL, [$originalContent, $readingTime, $subscriptionLinks]));
    }
}
