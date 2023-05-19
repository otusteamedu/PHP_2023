<?php

namespace Sva\Common\Infrastructure;

abstract class AbstractPresenter
{
    abstract public function present(object $data): array;
}
