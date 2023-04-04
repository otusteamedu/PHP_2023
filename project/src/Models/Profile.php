<?php

declare(strict_types=1);

namespace Vp\App\Models;

class Profile extends BaseModel
{
    protected static function getTableName(): string
    {
        return 'profiles';
    }
}
