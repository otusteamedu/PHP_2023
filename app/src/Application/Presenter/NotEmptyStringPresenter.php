<?php

declare(strict_types=1);

namespace App\Application\Presenter;

use App\Domain\ValueObject\NotEmptyString;

final class NotEmptyStringPresenter
{
    public function present(NotEmptyString $notEmptyString): string
    {
        return $notEmptyString->getValue();
    }
}
