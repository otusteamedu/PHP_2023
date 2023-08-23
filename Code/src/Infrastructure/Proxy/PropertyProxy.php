<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Proxy;

use Art\Code\Domain\Property;
use Art\Php2023\Infrastructure\Contact\PropertyInterface;

class PropertyProxy extends Property implements PropertyInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute(array $getData)
    {
        if (
            isset($getData['need_cadastral_info']) &&
            $this->cadastralInformation === null
        ) {
            sleep(3);
            $this->cadastralInformation = 'got an information from cadastrals api';
        }

        $this->store();
    }
}