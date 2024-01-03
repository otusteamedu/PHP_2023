<?php

namespace Ad\Infrastructure;

use Ad\App\AddResult;
use JsonException;

class AddResultArrayPresenter
{
    /**
     * @throws JsonException
     */
    public static function present(AddResult $arResult): string
    {
        return json_encode($arResult, JSON_THROW_ON_ERROR);
    }
}