<?php

declare(strict_types=1);

namespace Vp\App\Models;

use Vp\App\Storage\Relation;

/**
 * @property string|null $id
 * @property string|null $login
 * @property string|null $email
 */
class User extends BaseModel
{
    protected static function getTableName(): string
    {
        return 'users';
    }

    public function profile(): Relation
    {
        return $this->getRelation(Profile::class);
    }
}
