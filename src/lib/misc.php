<?php

function is_cli(): bool
{
    return !http_response_code();
}

function getEOL($isCli): string
{
    return $isCli ? PHP_EOL : '<br>';
}
