<?php

declare(strict_types=1);

namespace Art\Php2023\Infrastructure\Contact;

interface PropertyInterface
{
    public function execute(array $getData);
}