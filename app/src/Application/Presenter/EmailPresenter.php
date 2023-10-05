<?php

declare(strict_types=1);

namespace App\Application\Presenter;

use App\Domain\ValueObject\Email;

final class EmailPresenter
{
    public function present(Email $email): string
    {
        return $email->getValue();
    }
}
