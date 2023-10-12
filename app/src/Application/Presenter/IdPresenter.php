<?php

declare(strict_types=1);

namespace App\Application\Presenter;

use App\Domain\ValueObject\Id;

final class IdPresenter
{
    public function present(Id $id): int
    {
        return (int) $id->getValue();
    }
}
