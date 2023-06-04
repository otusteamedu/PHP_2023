<?php

declare(strict_types=1);

namespace Vp\App\Domain\Model;

use Vp\App\Application\Exception\FindEntityFailed;
use Vp\App\Domain\Contract\DatabaseInterface;

/**
 * @property int $id
 * @property int $product_id
 * @property int $quantity
 * @property int $status_id
 */
class Order extends BaseModel
{
    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);
    }

    protected static function getTableName(): string
    {
        return 'orders';
    }

    /**
     * @throws FindEntityFailed
     */
    public function status(): BaseModel
    {
        $statusModel = new Status($this->db);
        return $statusModel->findOne($this->status_id);
    }
}
