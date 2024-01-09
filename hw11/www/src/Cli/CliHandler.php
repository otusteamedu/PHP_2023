<?php
declare(strict_types=1);
namespace Shabanov\Otusphp\Cli;
class CliHandler
{
    private CONST ARGV_PARAMS = 'c:p:t:';
    public function __construct() {}

    public function run(): array
    {
        return getopt(self::ARGV_PARAMS);
    }
}
