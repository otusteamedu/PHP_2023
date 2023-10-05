<?php

declare(strict_types=1);

namespace App\Application\Presenter;

use App\Domain\ValueObject\Content;

final class ContentPresenter
{
    public function present(Content $content): string
    {
        return $content->getValue();
    }
}
