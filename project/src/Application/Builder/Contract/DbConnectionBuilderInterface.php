<?php

declare(strict_types=1);

namespace Vp\App\Application\Builder\Contract;

use Vp\App\Domain\Contract\DatabaseInterface;

interface DbConnectionBuilderInterface
{
    public function build(): DatabaseInterface;
    public function getHost(): string;
    public function getPort(): string;
    public function getName(): string;
    public function getUser(): string;
    public function getPassword(): string;
}
