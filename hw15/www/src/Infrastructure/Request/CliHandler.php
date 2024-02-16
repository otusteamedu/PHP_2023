<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Infrastructure\Request;
use Shabanov\Otusphp\Infrastructure\Request\RequestInterface;

class CliHandler implements RequestInterface
{
    private CONST ARGV_PARAMS = 'c:p:t:';
    public function __construct() {}

    public function process(): array
    {
        return getopt(self::ARGV_PARAMS);
    }
}
