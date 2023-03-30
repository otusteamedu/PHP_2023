<?php

declare(strict_types=1);

namespace Vp\App\Storage;

use Vp\App\Config;

trait StorageManager
{
    public function getStorage(): StorageInterface
    {

        $storageType = Config::getInstance()->getStorageType();

        switch ($storageType) {
            case 'psql':
                return new StoragePsql();
            case 'redis':
            default:
                return new StorageRedis();
        }
    }
}
