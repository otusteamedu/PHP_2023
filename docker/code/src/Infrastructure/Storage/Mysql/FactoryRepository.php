<?php


namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql;

use IilyukDmitryi\App\Domain\Repository\EventRepositoryInterface;
use IilyukDmitryi\App\Domain\Repository\FactoryRepositoryInterface;
use IilyukDmitryi\App\Domain\Repository\PurchaseRepositoryInterface;
use IilyukDmitryi\App\Domain\Repository\UserPurchaseRepositoryInterface;
use IilyukDmitryi\App\Domain\Repository\TransactionRepositoryInterface;
use IilyukDmitryi\App\Domain\Repository\UserRepositoryInterface;
use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;
use IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository\EventRepository;
use IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository\PurchaseRepository;
use IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository\UserRepository;
use IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository\UserPurchaseRepository;
use IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository\TransactionRepository;
use PDO;



class FactoryRepository implements FactoryRepositoryInterface
{
    /**
     * @var PDO
     */
    private static ?PDO $pdo = null;
    
    public function __construct()
    {
        if (is_null(static::$pdo)) {
            $settings = ConfigApp::get();
            $dbHost = $settings->getMysqlHost();
            $dbName = $settings->getMysqlDbName();
            $dbUser = $settings->getMysqlUser();
            $dbPass = $settings->getMysqlPass();
            
            static::$pdo = new PDO(
                "mysql:host={$dbHost};dbname={$dbName}",
                $dbUser,
                $dbPass,
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }
    }

    
    public function getEventRepository(): EventRepositoryInterface
    {
        return new EventRepository(static::$pdo);
    }
    
    public function getPurchaseRepository(): PurchaseRepositoryInterface
    {
        return new PurchaseRepository(static::$pdo);
    }
    public function getUserRepository(): UserRepositoryInterface
    {
        return new UserRepository(static::$pdo);
    }
    
    public function getUserPurchaseRepository(): UserPurchaseRepositoryInterface
    {
        return new UserPurchaseRepository(static::$pdo);
    }
    public function getTransactionRepository(): TransactionRepositoryInterface
    {
        return new TransactionRepository(static::$pdo);
    }
}