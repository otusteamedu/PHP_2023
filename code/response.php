<?php

namespace app;

class Response
{
    public const STATUS_OK = 'HTTP/1.1 200 OK';
    public const STATUS_BAD_REQUEST = 'HTTP/1.1 400 Bad Request';
    public const POST_PARAM_IS_MISSING = 'Parameter "string" is missing.';
    public const POST_PARAM_IS_EMPTY = 'Parameter "string" is empty!';
    public const POST_PARAM_VALUE_IS_NOT_VALID = 'Incorrect string - braces are not paired.';
    public const POST_PARAM_VALUE_IS_CORRECT = 'Everything is fine.';
}
