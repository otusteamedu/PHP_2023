<?php

declare(strict_types=1);

namespace Dmitryesaulenko\Php2023;

class Response
{
    const ERROR_EMPTY_REQUEST = 'Wrong request';
    const ERROR_REGEXP = 'No valid mail';
    const ERROR_DNS = 'Check DNS failed';

    const EMPTY_REQUEST_STATUS = 400;
}
