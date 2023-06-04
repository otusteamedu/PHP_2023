<?php

declare(strict_types=1);

namespace Vp\App\Domain\Model;

use Vp\App\Domain\Contract\DatabaseInterface;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 */
class Status extends BaseModel
{
    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);
    }
    protected static function getTableName(): string
    {
        return 'statuses';
    }
}
