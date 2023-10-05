<?php

declare(strict_types=1);

namespace App\Application\Presenter;

use App\Application\ViewModel\PaginationViewModel;
use App\Domain\Repository\Pagination;

final class PaginationPresenter
{
    public function present(Pagination $pagination): PaginationViewModel
    {
        return new PaginationViewModel(
            $pagination->getPage(),
            $pagination->getPerPage(),
            $pagination->getCount(),
            $pagination->getCountPages(),
        );
    }
}
