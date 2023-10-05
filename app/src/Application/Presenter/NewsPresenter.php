<?php

declare(strict_types=1);

namespace App\Application\Presenter;

use App\Application\Decorator\Content\ContentDecorator;
use App\Application\ViewModel\NewsViewModel;
use App\Domain\Entity\News;
use App\Domain\ValueObject\Content;

final class NewsPresenter
{
    /**
     * @param iterable<ContentDecorator> $contentDecorators
     */
    public function __construct(
        private readonly IdPresenter $idPresenter,
        private readonly NotEmptyStringPresenter $notEmptyStringPresenter,
        private readonly ContentPresenter $contentPresenter,
        private readonly DateTimePresenter $dateTimePresenter,
        private iterable $contentDecorators,
    ) {
    }

    public function present(News $news): NewsViewModel
    {
        $content = $this->decorateContent($news->getContent());

        return new NewsViewModel(
            $this->idPresenter->present($news->getId()),
            $this->idPresenter->present($news->getAuthor()->getId()),
            $this->idPresenter->present($news->getCategory()->getId()),
            $this->notEmptyStringPresenter->present($news->getTitle()),
            $this->contentPresenter->present($content),
            $this->dateTimePresenter->present($news->getCreatedAt()),
        );
    }

    private function decorateContent(Content $content): Content
    {
        foreach ($this->contentDecorators as $contentDecorator) {
            $content = new $contentDecorator($content);
        }

        return $content;
    }
}
