<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\Presenter;

final class DateTimePresenter
{
    public function present(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format('Y-m-d H:i:s');
    }
}
