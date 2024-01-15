<?php

declare(strict_types=1);

namespace Common\Domain\User;

use Common\Domain\DomainException\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The user you requested does not exist.';
}
